<?php

use App\Notifications\ThreadWasUpdated;
use Faker\Generator as Faker;
use Ramsey\Uuid\Uuid;

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
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token'    => str_random(10),
    ];
});

$factory->define(App\Channel::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => $name,
        'slug' => $name,
    ];
});

$factory->define(App\Thread::class, function (Faker $faker) {
    return [
        'user_id'    => function () {
            return factory(App\User::class)->create()->id;
        },
        'channel_id' => function () {
            return factory(App\Channel::class)->create()->id;
        },
        'title'      => $faker->sentence,
        'body'       => $faker->paragraph,
    ];
});

$factory->define(App\Reply::class, function (Faker $faker) {
    return [
        'thread_id' => function () {
            return factory(App\Thread::class)->create()->id;
        },
        'user_id'   => function () {
            return factory(App\User::class)->create()->id;
        },
        'body'      => $faker->paragraph,
    ];
});

$factory->define(App\Favorite::class, function (Faker $faker) {
    return [
        'user_id'        => function () {
            return factory(App\User::class)->create()->id;
        },
        'favorited_id'   => function () {
            return create(App\Reply::class)->id;
        },
        'favorited_type' => App\Reply::class,
    ];
});

$factory->define(Illuminate\Notifications\DatabaseNotification::class, function (Faker $faker) {
    return [
        'id'              => Uuid::uuid4()->toString(),
        'type'            => ThreadWasUpdated::class,
        'notifiable_id'   => function () {
            return auth()->id() ?? create(App\User::class)->id;
        },
        'notifiable_type' => App\User::class,
        'data'            => ['foo' => 'bar'],
    ];
});
