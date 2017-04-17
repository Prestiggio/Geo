<?php
$factory->define(\Ry\Geo\Models\Ville::class, function(Faker\Generator $faker){
	return [
			"nom" => $faker->city,
			"cp" => $faker->postcode,
			"country_id" => 0
	];
});