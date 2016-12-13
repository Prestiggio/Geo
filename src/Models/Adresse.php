<?php namespace Ry\Geo\Models;

use Illuminate\Database\Eloquent\Model;

class Adresse extends Model {

	public function ville() {
		return $this->belongsTo("Ry\Geo\Models\Ville", "ville_id");
	}
	
	public static function firstOrCreateFromBulk(array $attributes) {
		Model::unguard();
		
		$country = Country::firstOrCreate($attributes["city"]["country"]);
		
		$attributes["city"]["country_id"] = $country->id;
		
		unset($attributes["city"]["country"]);
		
		$ville = Ville::firstOrCreate($attributes["city"]);
		
		$attributes["ville_id"] = $ville->id;
		
		unset($attributes["city"]);
		
		$address = static::firstOrCreate($attributes);
		
		Model::reguard();
		
		return $address;
	}

}
