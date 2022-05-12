<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnFilterFieldTypeCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('custom_fields', function (Blueprint $table) {
            $table->string('filter_field_type')->after('filter')->nullable();
            $table->string('min')->after('filter_field_type')->nullable();
            $table->string('max')->after('min')->nullable();
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
            $table->dropColumn('filter_field_type');
            $table->dropColumn('min');
            $table->dropColumn('max');
        });
    }
}
