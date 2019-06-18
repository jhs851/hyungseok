<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\{Comment, Development, User};
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'development_id' => function () {
            return factory(Development::class)->create()->id;
        },
        'body' => $faker->paragraph,
    ];
});
