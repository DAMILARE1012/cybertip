<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ThreatIntel;
use Faker\Generator as Faker;

$factory->define(ThreatIntel::class, function (Faker $faker) {
    return [
        'alias' => $faker->userName,
        'real_name' => $faker->name,
        'post' => $faker->text(100),
        'url' => $faker->imageUrl,
        'time' => $faker->dateTimeThisYear,
        'geolocation' => $faker->state,
        'source' => "Twitter",
    ];
});
