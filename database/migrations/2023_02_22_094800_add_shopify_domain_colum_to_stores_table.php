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
        Schema::table('stores', function (Blueprint $table) {
            $table->string('myshopify_domain')->nullable()->after('default');
            $table->unsignedBigInteger('shopify_id')->nullable()->after('myshopify_domain');
            $table->string('access_token')->nullable()->after('shopify_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('myshopify_domain');
            $table->dropColumn('shopify_id');
            $table->dropColumn('access_token');
        });
    }
};
