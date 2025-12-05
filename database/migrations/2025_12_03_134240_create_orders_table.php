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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();  // id int [pk, increment]
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');  // ref users.id
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->onDelete('set null');  // ref discounts.id
            $table->decimal('total_amount', 10, 2);  // total_amount decimal(10,2) [not null]
            $table->decimal('discount_amount', 10, 2)->default(0);  // discount_amount
            $table->enum('status', ['pending', 'paid', 'shipped', 'cancelled'])->default('pending');  // status enum
            $table->enum('payment_method', ['momo', 'stripe', 'cod'])->nullable();  // payment_method enum
            $table->string('payment_id')->nullable();  // payment_id string [null]
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
