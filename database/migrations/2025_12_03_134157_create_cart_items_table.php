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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();  // id int [pk, increment]
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // ref users.id
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');  // ref products.id
            $table->integer('quantity')->default(1);  // quantity int [default: 1]
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
