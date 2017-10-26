<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\ClimbSession::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTime(),
        'name' => $faker->sentence(3),
    ];
});
