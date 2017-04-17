<?php
use Ry\RealEstate\Models\Immobilier;
$factory->define(\Ry\Geo\Models\Adresse::class, function(Faker\Generator $faker){
	return [
			"ville_id" => 0,
			"raw" => $faker->address,
			"lat" => $faker->latitude,
			"lng" => $faker->longitude
	];
});