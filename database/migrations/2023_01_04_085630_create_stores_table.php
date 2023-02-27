<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('store_name');
            $table->string('store_email')->unique();
            $table->string('store_mobile')->unique();
            $table->string('store_logo')->nullable();
            $table->string('country');
            $table->string('city');
            $table->string('state')->nullable();
            $table->integer('pincode')->nullable();
            $table->string('address');
            $table->enum('status',['active','inactive','blocked'])->default('active');
            $table->enum('default',[1,0])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
