<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Latlngchars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ry_geo_adresses', function (Blueprint $table) {
            $table->string("lat", 50)->nullable()->change();
            $table->string("lng", 50)->nullable()->change();
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
            //
        });
    }
}
