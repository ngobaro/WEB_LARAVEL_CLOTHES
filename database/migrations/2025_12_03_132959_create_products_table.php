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
    Schema::create('products', function (Blueprint $table) {
        $table->id();  // id int [pk, increment]
        $table->string('name');  // name string [not null]
        $table->decimal('price', 10, 2);  // price decimal(10,2) [not null]
        $table->text('description')->nullable();  // description text
        $table->integer('stock')->default(0);  // stock int [default: 0]
        $table->string('image_url')->nullable();  // image_url string [null]
        $table->foreignId('discount_id')->nullable()->constrained('discounts')->onDelete('set null');
        $table->timestamps();  // created_at, updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::dropIfExists('products');
}
};
