<?php

/*
|--------------------------------------------------------------------------
| candidate Factory
|--------------------------------------------------------------------------
|
| Here you may define the candidate factory. Factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how the candidate model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Optymous\candidate::class, function (Faker\Generator $faker) {
	return [
		'first_name' => $faker->lastName,
		'last_name' => $faker->lastName,
		'email' => $faker->email,
		'phone' => str_random(16),
		'status' => str_random(16),
		'dob' => str_random(16),
	];
});