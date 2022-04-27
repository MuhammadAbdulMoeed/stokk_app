<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnUserLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_locations', function (Blueprint $table) {
            $table->dropColumn('country_lat')->nullable();
            $table->dropColumn('country_lng')->nullable();
            $table->dropColumn('city_lat')->nullable();
            $table->dropColumn('city_lng')->nullable();

            $table->string('lat')->after('city')->nullable();
            $table->string('lng')->after('city')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_locations', function (Blueprint $table) {
            $table->string('country_lat')->nullable();
            $table->string('country_lng')->nullable();
            $table->string('city_lat')->nullable();
            $table->string('city_lng')->nullable();

            $table->dropColumn('lat')->nullable();
            $table->dropColumn('lng')->nullable();
        });
    }
}
