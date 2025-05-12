<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topups', function (Blueprint $table) {
            $table->bigIncrements('topupID');
            $table->unsignedBigInteger('userID');
            $table->string('method')->default('-');
            $table->decimal('amount', 12, 2);
            $table->timestamp('transdate');
            $table->integer('status')->default(0);
            $table->string('snap_token')->nullable();

            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('topups');
    }
};
