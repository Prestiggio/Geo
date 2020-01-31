<?php namespace Ry\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Ry\Geo\Http\Controllers\BotController;
use Illuminate\Support\Facades\Log;
use Ry\Profile\Models\Traits\JoinableTrait;

class Adresse extends Model {

	//protected $with = ["ville"];
	
    use JoinableTrait;
	
	protected $table = "ry_geo_adresses";
	
	public function ville() {
		return $this->belongsTo("Ry\Geo\Models\Ville", "ville_id");
	}
	
	public static function firstOrCreateFromBulk(array $attributes) {

		
		$address = app("\Ry\Geo\Http\Controllers\PublicController")->generate($attributes);
		

		
		return $address;
	}
	
	public static function locate($ar) {
		if(is_array($ar)){
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
		}
		elseif(is_string($ar)) {
			$q = $ar;
			$ar = [];
			$results = app("rymd.search")->search("adresse", $q);
			foreach($results as $result) {
				foreach($result as $row) {
					$ar[$row->id] = $row;
				}
			}
			$results = app("rymd.search")->search("ville", $q);
			foreach($results as $result) {
				foreach($result as $row) {
					foreach($row->adresses as $adresse)
						$ar[$adresse->id] = $adresse;
				}
			}
			$results = app("rymd.search")->search("country", $q);
			foreach($results as $result) {
				foreach($result as $row) {
					foreach($row->villes as $ville) {
						foreach($ville->adresses as $adresse)
							$ar[$adresse->id] = $adresse;
					}
				}
			}
			return new Collection(array_values($ar));
		}
		return [];
	}
	
	public static function form($form, $model) {
		$form->where();
		$form->expect(BotController::class . "@postPosition", $model);
	}
	
	public function getGeocodableAttribute() {
	    return $this->raw . ', ' . $this->ville->cp . ' ' . $this->ville->nom . ', ' . $this->ville->country->nom;
	}

}
