<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();

            $table->string('product_type')->comment('rent,sale')->nullable();
            $table->string('per_hour')->nullable();
            $table->string('full_rate')->nullable();
            $table->string('style')->nullable();
            $table->string('material')->nullable();
            $table->string('gender')->nullable();

            $table->string('length')->nullable();


            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')
                ->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('item_condition_id')->nullable();
            $table->foreign('item_condition_id')->references('id')
                ->on('item_conditions')->onDelete('cascade');

            $table->unsignedBigInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')
                ->on('brands')->onDelete('cascade');

            $table->unsignedBigInteger('class_id')->nullable();
            $table->foreign('class_id')->references('id')
                ->on('classes')->onDelete('cascade');

            $table->unsignedBigInteger('size_id')->nullable();
            $table->foreign('size_id')->references('id')
                ->on('sizes')->onDelete('cascade');


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
        Schema::dropIfExists('product_details');
    }
}
