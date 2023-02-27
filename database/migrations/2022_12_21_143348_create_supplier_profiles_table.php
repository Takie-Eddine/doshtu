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
        Schema::create('supplier_profiles', function (Blueprint $table) {
            $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('photo')->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender' , ['male' , 'female'])->nullable();
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->char('country',2);
            $table->char('locale',4)->default('en');
            $table->timestamps();


            $table->primary('supplier_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supplier_profiles');
    }
};
