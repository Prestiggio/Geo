<?php namespace Ry\Geo\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model {

	public function country() {
		return $this->belongsTo("Ry\Geo\Models\Country", "country_id");
	}
	
	public function adresses() {
		return $this->hasMany("Ry\Geo\Models\Adresse", "ville_id");
	}

}
