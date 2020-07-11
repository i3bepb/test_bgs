<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Member;
use Faker\Generator as Faker;

$factory->define(Member::class, function (Faker $faker) {
    $now = now();
    return [
        'name'       => $faker->firstName(),
        'surname'    => $faker->lastName,
        'email'      => $faker->email,
        'created_at' => $now,
        'updated_at' => $now
    ];
});
