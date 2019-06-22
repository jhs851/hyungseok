<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\{Activity, Development, User};
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    $development = factory(Development::class)->create();

    return [
        'subject_type' => get_class($development),
        'subject_id' => $development->id,
        'type' => 'created_development',
        'user_id' => $development->user->id,
    ];
});
