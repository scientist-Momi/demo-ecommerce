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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->string('role');
            $table->uuid('created_by');
            $table->foreign('created_by')->references('user_id')->on('users')->onDelete('cascade');
            $table->timestamps();

        //     $table->id();
        //     $table->uuid('user_id')->constrained('users')->onDelete('cascade');
        //    $table->string('role');
        //     $table->foreignId('created_by')->nullable()->constrained('users', 'user_id')->onDelete('set null');
        //     $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
