<?php namespace Ry\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Ry\Analytics\Models\Traits\LinkableTrait;

class Ville extends Model {
	
	use LinkableTrait;

	protected $table = "ry_geo_villes";
	
	protected $with = ["country"];

	protected $fillable = ["nom"];
	
	public function country() {
		return $this->belongsTo("Ry\Geo\Models\Country", "country_id");
	}
	
	public function adresses() {
		return $this->hasMany("Ry\Geo\Models\Adresse", "ville_id");
	}
	
	public function getSlugAttribute() {
		return str_slug($this->country->slug . " " . $this->cp . " " . $this->nom);
	}

}
