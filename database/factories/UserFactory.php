<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => 'password',
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class, 'unconfirmed', function (Faker $faker) {
    return [
        'email_verified_at' => null,
    ];
});

$factory->state(User::class, 'admin', function (Faker $faker) {
    return [
        'name' => config('auth.admin.name'),
        'email' => config('auth.admin.email')[0],
    ];
});
