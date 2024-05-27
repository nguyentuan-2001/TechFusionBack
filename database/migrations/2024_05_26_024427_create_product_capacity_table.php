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
        Schema::create('product_capacity', function (Blueprint $table) {
            $table->id('product_capacity_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('storage_capacity_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->foreign('storage_capacity_id')->references('storage_capacity_id')->on('storage_capacity')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_capacity');
    }
};
