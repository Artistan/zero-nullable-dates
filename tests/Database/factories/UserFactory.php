<?php

use Artistan\ZeroNullDates\Tests\Database\ZeroNullableUser as User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

/** @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    $base_attributes = [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];

    foreach (User::date_keys() as $key) {
        $base_attributes[$key] = $faker->dateTime;
    }

    return $base_attributes;
});

// use all the dates to define "states" for the factory, then we can build all combinations with arrays of states
foreach (User::$zero_date as $key) {
    $factory->state(User::class, $key, [
        $key => '0000-00-00',
    ]);
}

foreach (User::$zero_datetime as $key) {
	$factory->state(User::class, $key, [
		$key => '0000-00-00 00:00:00',
	]);
}

foreach (User::$nullable as $key) {
    $factory->state(User::class, $key, [
        $key => null,
    ]);
}

