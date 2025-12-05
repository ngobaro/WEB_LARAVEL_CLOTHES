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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();  // id int [pk, increment]
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');  // ref orders.id
            $table->decimal('amount', 10, 2);  // amount decimal(10,2) [not null]
            $table->enum('payment_method', ['momo', 'stripe', 'cod', 'bank_transfer']);  // payment_method enum
            $table->string('transaction_id')->nullable();  // transaction_id string [null]
            $table->enum('status', ['pending', 'success', 'failed', 'refunded'])->default('pending');  // status enum
            $table->json('response_data')->nullable();  // response_data json [null]
            $table->timestamp('paid_at')->nullable();  // paid_at timestamp [null]
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
