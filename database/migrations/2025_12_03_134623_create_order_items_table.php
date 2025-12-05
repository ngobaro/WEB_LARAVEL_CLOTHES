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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();  // id int [pk, increment]
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');  // ref orders.id
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');  // ref products.id
            $table->integer('quantity');  // quantity int [not null]
            $table->decimal('price_at_time', 10, 2);  // price_at_time decimal(10,2) [not null]
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
