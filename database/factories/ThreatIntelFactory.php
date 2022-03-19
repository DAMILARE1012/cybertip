<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ThreatIntel;
use Faker\Generator as Faker;

$factory->define(ThreatIntel::class, function (Faker $faker) {
    return [
        'alias' => $faker->name,
        'real_name' => $faker->name,
        'post' => $faker->text,
        'url' => $faker->imageUrl,
        'time' => $faker->dateTimeThisYear,
        'geolocation' => $faker->state,
        'source' => "Twitter",
    ];
});
