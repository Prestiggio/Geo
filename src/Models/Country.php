<?php namespace Ry\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Ry\Analytics\Models\Traits\LinkableTrait;

class Country extends Model {
	
	use LinkableTrait;
	
	protected $table = "ry_geo_countries";
	
	protected $visible = ["id", "nom", "slug"];
	
	protected $appends = ["slug"];
	
	protected $fillable = ["nom"];
	
	protected static function boot() {
	    parent::boot();
	    
	    static::addGlobalScope("localefirst", function($a){
	        $a->orderByRaw("FIELD(nom, 'France') DESC, nom ASC");
	    });
	}

	public function villes() {
		return $this->hasMany("Ry\Geo\Models\Ville", "country_id");
	}
	
	public function getSlugAttribute() {
		return str_slug($this->nom);
	}

}
