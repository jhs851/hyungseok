<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\{Development, Favorite, User};
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    $development = factory(Development::class)->create();

    return [
        'favorited_type' => get_class($development),
        'favorited_id' => $development->id,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});
