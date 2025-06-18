<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('productID');
            $table->string('name');
            $table->unsignedBigInteger('categoryID');
            $table->decimal('price', 8, 2);
            $table->float('rating', 3, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('img_url')->nullable();
            $table->integer('fat');
            $table->integer('calories');
            $table->integer('protein');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('categoryID')->references('categoryID')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
