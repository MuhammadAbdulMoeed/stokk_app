<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationColumnsCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_fields', function (Blueprint $table) {

            $table->unsignedBigInteger('parent_id')->after('order')->nullable();
            $table->foreign('parent_id')->references('id')->on('custom_fields')
                ->onDelete('cascade');

            $table->unsignedBigInteger('option_id')->after('parent_id')->nullable();
            $table->foreign('option_id')->references('id')->on('custom_field_options')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('custom_fields', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');

            $table->dropForeign(['option_id']);
            $table->dropColumn('option_id');
        });
    }
}
