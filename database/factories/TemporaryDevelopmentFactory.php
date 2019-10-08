<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\{Development, TemporaryDevelopment, User};
use Faker\Generator as Faker;

$factory->define(TemporaryDevelopment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'development_id' => function () {
            return factory(Development::class)->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
    ];
});
