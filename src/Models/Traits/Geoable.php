<?php
namespace Ry\Geo\Models\Traits;

trait Geoable
{
	public function address() {
		return $this->belongsTo("Ry\Geo\Models\Adresse", "address_id");
	}
}