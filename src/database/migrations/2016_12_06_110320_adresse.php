<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Adresse extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ry_geo_adresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer("ville_id")->nullable();
			$table->char("raw");
			$table->char("raw2")->nullable();
			$table->char("lat", 50)->nullable();
			$table->char("lng", 50)->nullable();
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
		Schema::drop('ry_geo_adresses');
	}

}
