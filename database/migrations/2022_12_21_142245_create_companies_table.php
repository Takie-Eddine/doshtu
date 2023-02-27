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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->unique();
            $table->string('mobile')->unique();
            $table->string('office_mobile')->nullable()->unique();
            $table->string('email')->unique();
            $table->text('description');
            $table->string('address');
            $table->string('country');
            $table->string('city');
            $table->string('state')->nullable();
            $table->integer('pincode')->nullable();
            $table->string('website')->nullable();
            $table->string('logo')->nullable();
            $table->enum('is_active',['active','unactive','blocked'])->default('active');
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('telegram')->nullable();
            $table->string('linkedin')->nullable();
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
        Schema::dropIfExists('companies');
    }
};
