<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSkuToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable();
            $table->string('vpn')->nullable();
            $table->string('min_description')->nullable();
            $table->string('product_type')->nullable();
            $table->string('product_material')->nullable();
            $table->string('dimenssions')->nullable();
            $table->string('weight')->nullable();
            $table->string('features')->nullable();
            $table->string('location')->nullable();
            $table->string('warranty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
}
