<?php
namespace Ry\Geo\Models\Traits;

trait Geoable
{
	public function adresse() {
		return $this->belongsTo("Ry\Geo\Models\Adresse", "adresse_id");
	}
	
	public function getCompleteAddressAttribute() {
		return $this->adresse->raw . "<br/>" . $this->adresse->ville->cp . " " . $this->adresse->ville->nom . "<br/>" . $this->adresse->ville->country->nom;
	}
	
	public function getGeocodableAddressAttribute() {
	    return $this->adresse->geocodable;
	}
}