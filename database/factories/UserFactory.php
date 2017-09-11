<?php

use Faker\Generator as Faker;
use App\Channel;
use App\Thread;

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

$factory->define(App\User::class, function (Faker $faker) {

    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Reply::class, function (Faker $faker) {

    return [
        'user_id' => function () {

            return factory(App\User::class)->create()->id;
        },
        'thread_id' => function () {

            return factory(Thread::class)->create()->id;
        },
        'body' => $faker->paragraph(),
    ];
});

$factory->define(App\Thread::class, function (Faker $faker) {

    return [
        'user_id' => function () {

            return factory(App\User::class)->create()->id;
        },

        'channel_id' => function () {
            return factory(Channel::class)->create()->id;
        },

        'title' => $faker->sentence(),
        'body' => $faker->paragraph(),
    ];
});

$factory->define(App\Channel::class, function (Faker $faker) {

    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name,
    ];
});

