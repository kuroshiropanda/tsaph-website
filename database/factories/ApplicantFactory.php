<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Applicant;
use Faker\Generator as Faker;

$factory->define(Applicant::class, function (Faker $faker) {
    return [
        'twitch_id' => $faker->randomNumber(9),
        'username' => $faker->username,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
    ];
});
