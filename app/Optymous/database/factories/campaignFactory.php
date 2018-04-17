<?php

/*
|--------------------------------------------------------------------------
| campaign Factory
|--------------------------------------------------------------------------
|
| Here you may define the campaign factory. Factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how the campaign model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Optymous\campaign::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->lastName,
		'start_date' => $faker->dateTime,
		'end_date' => $faker->dateTime,
		'status' => str_random(16),
		'available_jobs' => str_random(16),
		'description' => str_random(16),
	];
});