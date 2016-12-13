<?php
namespace Ry\Geo\Models\Traits;

trait Geoable
{
	public function address() {
		return $this->belongsTo("Ry\Geo\Models\Adresse", "adresse_id");
	}
	
	public function getCompleteAddressAttribute() {
		return $this->address->raw . "<br/>" . $this->address->ville->cp . " " . $this->address->ville->nom . "<br/>" . $this->address->ville->country->nom;
	}
}