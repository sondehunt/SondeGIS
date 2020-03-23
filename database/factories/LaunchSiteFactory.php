<?php

use App\LaunchSite;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(
    LaunchSite::class,
    static function (Faker $faker) {
        return [
            'approved_at' => now(),
            'name' => $faker->company,
            'operator' => $faker->name,
            'latitude' => $faker->latitude,
            'longitude' => $faker->longitude,
            'wmo_id' => $faker->randomNumber(5),
            'head' => true,
        ];
    }
);
