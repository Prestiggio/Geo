<?php namespace Ry\Geo\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
	
	protected $table = "ry_geo_countries";

	public function villes() {
		return $this->hasMany("Ry\Geo\Models\Ville", "country_id");
	}

}
