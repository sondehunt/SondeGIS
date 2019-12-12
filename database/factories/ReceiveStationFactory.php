<?php

use App\ReceiveStation;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(ReceiveStation::class, static function (Faker $faker) {
    return [
        'approved_at' => now(),
        'name' => $faker->company,
        'operator' => $faker->name,
        'lat' => $faker->latitude,
        'long' => $faker->longitude,
    ];
});
