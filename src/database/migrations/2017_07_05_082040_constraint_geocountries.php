<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintGeocountries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ry_geo_countries', function (Blueprint $table) {
            $table->unique("nom");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ry_geo_countries', function (Blueprint $table) {
            $table->dropUnique("ry_geo_countries_nom_unique");
        });
    }
}
