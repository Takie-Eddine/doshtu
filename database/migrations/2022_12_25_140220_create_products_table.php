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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->float('price')->default(0);
            $table->float('selling_price')->default(0);
            $table->float('compare_price')->nullable();
            $table->float('global_price')->nullable();
            $table->unsignedBigInteger('shipping_time')->default(0);
            $table->string('sku')->unique();
            $table->string('quantity');
            $table->json('options')->nullable();
            $table->float('rating')->default(0);
            $table->boolean('featured')->default(0);
            $table->enum('status',['active' , 'inactive' , 'archived'])->default('inactive');
            $table->softDeletes();
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
        Schema::dropIfExists('products');
    }
};
