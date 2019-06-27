<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\User;
use App\Notifications\DevelopmentWasUpdated;
use Faker\Generator as Faker;
use Illuminate\Notifications\DatabaseNotification;
use Ramsey\Uuid\Uuid;

$factory->define(DatabaseNotification::class, function (Faker $faker) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'type' => DevelopmentWasUpdated::class,
        'notifiable_type' => User::class,
        'notifiable_id' => function () {
            return auth()->id() ?: factory(User::class)->create()->id;
        },
        'data' => ['foo' => 'bar'],
    ];
});
