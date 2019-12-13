<?php

use App\Hunter;
use App\LaunchSite;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Hunter::class, static function (Faker $faker) {
    return [
        'approved_at' => now(),
        'name' => $faker->company,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'radius' => $faker->numberBetween(20, 100),
        'activity' => $faker->randomFloat(null, 0, 1),
    ];
});
