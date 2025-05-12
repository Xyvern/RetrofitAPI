<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->bigIncrements('ratingID');
            $table->unsignedBigInteger('userID');
            $table->unsignedBigInteger('productID');
            $table->unsignedBigInteger('orderDetailID');
            $table->tinyInteger('rating')->unsigned();
            $table->timestamps();

            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
            $table->foreign('productID')->references('productID')->on('products')->onDelete('cascade');
            $table->foreign('orderDetailID')->references('orderDetailID')->on('order_details')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
