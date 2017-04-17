<?php
$factory->define(\Ry\Geo\Models\Country::class, function(Faker\Generator $faker){
	return [
			"nom" => $faker->country
	];
});