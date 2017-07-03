<?php namespace Ry\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Ry\Analytics\Models\Traits\LinkableTrait;

class Country extends Model {
	
	use LinkableTrait;
	
	protected $table = "ry_geo_countries";
	
	protected $appends = ["slug"];
	
	protected $fillable = ["nom"];

	public function villes() {
		return $this->hasMany("Ry\Geo\Models\Ville", "country_id");
	}
	
	public function getSlugAttribute() {
		return str_slug($this->nom);
	}

}
