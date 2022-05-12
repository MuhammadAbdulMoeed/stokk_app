<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnForeignKeyConstraintPivotCategoryFilters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pivot_category_filters', function (Blueprint $table) {

            $table->dropForeign(['filter_id']);
            $table->dropColumn('filter_id');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pivot_category_filters', function (Blueprint $table) {

            $table->unsignedBigInteger('filter_id')->nullable();
            $table->foreign('filter_id')->references('id')->on('filters')
                ->onDelete('cascade');
        });
    }
}
