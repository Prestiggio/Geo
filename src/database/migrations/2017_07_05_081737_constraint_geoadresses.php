<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConstraintGeoadresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ry_geo_adresses', function (Blueprint $table) {
        	$table->integer("ville_id", false, true)->change();
        	$table->foreign("ville_id")->references("id")->on("ry_geo_villes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ry_geo_adresses', function (Blueprint $table) {
            $table->dropForeign("ry_geo_adresses_ville_id_foreign");
            $table->dropIndex("ry_geo_adresses_ville_id_foreign");
        });
    }
}
