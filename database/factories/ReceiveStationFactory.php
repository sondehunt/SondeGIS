<?php

use App\ReceiveStation;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(
    ReceiveStation::class,
    static function (Faker $faker) {
        return [
            'approved_at' => now(),
            'name' => $faker->company,
            'operator' => $faker->name,
            'latitude' => $faker->latitude,
            'longitude' => $faker->longitude,
            'elevation' => $faker->numberBetween(-9999, 9999),
            'antenna_height' => $faker->numberBetween(0, 999),
            'antenna_type' => $faker->text,
            'processing_system_type' => $faker->text,
            'concurrent_receivers' => $faker->numberBetween(0, 99),
            'reporting_to' => [
                $faker->word,
                $faker->word,
                $faker->word,
            ],
            'head' => true,
        ];
    }
);
