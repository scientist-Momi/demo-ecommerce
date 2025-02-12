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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->unsignedBigInteger('tax_class_id');
            $table->foreign('tax_class_id')->references('id')->on('tax_classes')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('discounted_price', 10, 2)->default(0.00);
            $table->integer('stock_quantity')->default(0);
            $table->decimal('weight', 8, 2)->default(0);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_limited')->default(false);
            $table->boolean('is_active')->default(false);
            $table->timestamp('publish_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
