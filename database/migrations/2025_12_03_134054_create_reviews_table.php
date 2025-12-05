<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();  // id int [pk, increment]
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');  // ref products.id
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // ref users.id
            $table->integer('rating');  // rating int [not null, 1-5 sao]
            $table->text('comment')->nullable();  // comment text [null]
            $table->timestamps();  // created_at, updated_at

            $table->unique(['product_id', 'user_id']);  // unique index
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};
