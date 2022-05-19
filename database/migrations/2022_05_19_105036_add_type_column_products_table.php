<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeColumnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('type')->comment('for_sale,for_rent')
                ->after('price')->nullable();
            $table->string('per_hour_rent_price')->after('type')->nullable();
            $table->string('per_day_rent_price')->after('type')->nullable();
            $table->string('per_month_rent_price')->after('type')->nullable();
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
            $table->dropColumn('type');
            $table->dropColumn('per_hour_rent_price');
            $table->dropColumn('per_day_rent_price');
            $table->dropColumn('per_month_rent_price');
        });
    }
}
