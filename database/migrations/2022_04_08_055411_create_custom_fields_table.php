<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('field_type')->comment('input,number,select,multiselect');
            $table->string('slug')->nullable();
            $table->string('value_taken_from')->nullable();
            $table->string('order')->nullable();
            $table->boolean('is_required')->nullable();
            $table->boolean('is_active')->default(1)->comment('0=inactive,1=active');

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
        Schema::dropIfExists('custom_fields');
    }
}
