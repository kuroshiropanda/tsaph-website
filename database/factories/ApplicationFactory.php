<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Application;
use Faker\Generator as Faker;

$factory->define(Application::class, function (Faker $faker) {
    return [
        'applicant_id' => factory(App\Applicant::class),
        'answer_id' => factory(App\Answer::class),
        'question_id' => factory(App\Question::class),
    ];
});
