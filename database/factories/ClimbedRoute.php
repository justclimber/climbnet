<?php

use Faker\Generator as Faker;

/* @var Illuminate\Database\Eloquent\Factory $factory */

$factory->define(\App\ClimbedRoute::class, function (Faker $faker) {
    $catMin = \App\Lib\Dicts\RouteCategories::CATEGORY_MIN;
    $catMax = \App\Lib\Dicts\RouteCategories::CATEGORY_MAX;

    return [
        'name' => $faker->sentence(2),
        'category_dict' =>  $catMin + rand(0, $catMax - $catMin - 1) * rand(1, 6),
        'proposed_category_dict' =>  $catMin + rand(0, $catMax - $catMin - 1) * rand(1, 6)
    ];
});