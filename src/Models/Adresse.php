<?php namespace Ry\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Adresse extends Model {

	protected $with = ["ville"];
	
	protected $table = "ry_geo_adresses";
	
	public function ville() {
		return $this->belongsTo("Ry\Geo\Models\Ville", "ville_id");
	}
	
	public static function firstOrCreateFromBulk(array $attributes) {
		Model::unguard();
		
		if(isset($attributes["ville"]["country"])) {
			if(isset($attributes["ville"]["country"]["id"]) && $attributes["ville"]["country"]["id"]>0) {
				$country = Country::where("id", "=", $attributes["ville"]["country"]["id"])->first();
				if($country) {
					$country->nom = $attributes["ville"]["country"]["nom"];
					$country->save();
				}
			}
		}
		
		if(!isset($country))
			$country = Country::firstOrCreate($attributes["ville"]["country"]);
		
		$attributes["ville"]["country_id"] = $country->id;
		
		unset($attributes["ville"]["country"]);
		
		if(isset($attributes["ville"]["id"]) && $attributes["ville"]["id"]>0) {
			$ville = Ville::where("id", "=", $attributes["ville"]["id"])->first();
			if($ville) {
				$ville->nom = $attributes["ville"]["nom"];
				$ville->cp = $attributes["ville"]["cp"];
				$ville->country_id = $attributes["ville"]["country_id"];
				$ville->save();
			}
		}
		
		if(!isset($ville))
			$ville = Ville::firstOrCreate($attributes["ville"]);
		
		$attributes["ville_id"] = $ville->id;
		
		unset($attributes["ville"]);
		
		if(isset($attributes["id"]) && $attributes["id"]>0) {
			$address = Adresse::where("id", "=", $attributes["id"])->first();
			if($address) {
				$address->raw = $attributes["raw"];
				$address->ville_id = $attributes["ville_id"];
				if(isset($attributes["lat"]))
					$address->lat = $attributes["lat"];
				if(isset($attributes["lng"]))
					$address->lng = $attributes["lng"];
				$address->save();
			}
		}
		
		if(!isset($address))
			$address = static::firstOrCreate($attributes);
		
		Model::reguard();
		
		return $address;
	}
	
	public static function locate($ar) {
		if(isset($ar["ville"]) && isset($ar["ville"]["id"])) {
			return self::where("ville_id", "=", $ar["ville"]["id"])->get();
		}
		elseif(isset($ar["country"]) && isset($ar["country"]["id"])) {
			$country = Country::where("id", "=", $ar["country"]["id"])->first();
			$ar = [];
			foreach($country->villes as $ville) {
				foreach($ville->adresses as $adresse) {
					$ar[] = $adresse;
				}
			}
			return new Collection($ar);
		}
		return [];
	}
	
	public static function form($form, $model) {
		$form->where();
		$form->expect(action("\Ry\Geo\Http\Controllers\BotController@postPosition") . "?model=" . $model);
	}

}
