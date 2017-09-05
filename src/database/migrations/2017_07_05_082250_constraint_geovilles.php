<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintGeovilles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ry_geo_villes', function (Blueprint $table) {
        	$table->foreign("country_id")->references("id")->on("ry_geo_countries")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ry_geo_villes', function (Blueprint $table) {
            $table->dropForeign("ry_geo_villes_country_id_foreign");
            $table->dropIndex("ry_geo_villes_country_id_foreign");
        });
    }
}
