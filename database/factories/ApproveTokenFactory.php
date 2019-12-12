<?php

use App\ApproveToken;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(ApproveToken::class, static function (Faker $faker) {
    return [
        'token' => ApproveToken::generate(),
    ];
});
