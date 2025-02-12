<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id')->primary();
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'shipped', 'cancelled', 'completed'])->default('pending');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('tax', 10, 2)->default(0.00);
            $table->decimal('shipping_fee', 10, 2)->default(0.00);
            $table->enum('payment_method', ['credit_card', 'paypal', 'apple_pay'])->default('apple_pay');
            $table->string('transaction_id')->nullable();
            $table->unsignedBigInteger('shipping_address_id');
            $table->foreign('shipping_address_id')->references('id')->on('customer_addresses')->onDelete('cascade');
            $table->unsignedBigInteger('billing_address_id');
            $table->foreign('billing_address_id')->references('id')->on('customer_addresses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
