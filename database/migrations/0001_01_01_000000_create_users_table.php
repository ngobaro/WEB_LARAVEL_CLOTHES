<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
   public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();  // id int [pk, increment]
        $table->string('email')->unique();  // email string [unique, not null]
        $table->string('name');  // name string
        $table->string('password')->nullable();  // password string [null]
        $table->string('otp_code')->nullable();  // otp_code string [null]
        $table->timestamp('otp_expires')->nullable();  // otp_expires timestamp [null]
        $table->enum('role', ['customer', 'admin', 'seller'])->default('customer');  // role enum
        $table->timestamps();  // created_at, updated_at
    });
}

public function down()
{
    Schema::dropIfExists('users');
}
};
