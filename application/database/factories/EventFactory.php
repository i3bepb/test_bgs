<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name'    => $faker->catchPhrase(),
        'date_of' => $faker->dateTimeBetween('+3 days', '+30 days'),
        'city'    => $faker->unique()->city
    ];
});
