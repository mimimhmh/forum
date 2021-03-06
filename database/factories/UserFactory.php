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
        'confirmed' => true,
    ];
});

$factory->state(App\User::class, 'unconfirmed', function () {
    return [
        'confirmed' => false,
    ];
});

$factory->state(App\User::class, 'administrator', function () {
    return [
        'name' => 'JohnDoe',
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

    $title = $faker->sentence();

    return [
        'user_id' => function () {

            return factory(App\User::class)->create()->id;
        },

        'channel_id' => function () {
            return factory(Channel::class)->create()->id;
        },

        'title' => $title,
        'body' => $faker->paragraph(),
        'visits' => 0,
        'slug' => str_slug($title),
        'locked' => false,
    ];
});

$factory->define(App\Channel::class, function (Faker $faker) {

    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name,
    ];
});

$factory->define(App\Activity::class, function (Faker $faker) {

    return [
        'user_id' => rand(1, 51),
        '',
    ];
});

$factory->define(\Illuminate\Notifications\DatabaseNotification::class, function (Faker $faker) {

    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => 'App\Notifications\ThreadWasUpdated',
        'notifiable_id' => function () {
            return auth()->id() ?: factory(\App\User::class)->create()->id;
        },
        'notifiable_type' => 'App\User',
        'data' => ['foo' => 'bar'],
    ];
});

