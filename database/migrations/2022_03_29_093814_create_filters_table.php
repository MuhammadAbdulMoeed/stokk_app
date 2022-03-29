<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->id();

            $table->string('filter_name');
            $table->string('filter_type');
            $table->string('field_type');
            $table->string('min')->nullable();
            $table->string('max')->nullable();

            $table->boolean('is_active')->default(1)->comment('0=inactive, 1=active');

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
        Schema::dropIfExists('filters');
    }
}
