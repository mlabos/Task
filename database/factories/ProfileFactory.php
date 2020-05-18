<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Profile::class, function (Faker $faker) {
    return [
        'first_name' => $faker->text(10),
        'last_name' => $faker->text(10),
        'course' => $faker->text(5)
    ];
});
