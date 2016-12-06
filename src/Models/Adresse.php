<?php namespace Ry\Geo\Models;

use Illuminate\Database\Eloquent\Model;

class Adresse extends Model {

	public function ville() {
		return $this->belongsTo("Ry\Geo\Models\Ville", "ville_id");
	}

}
