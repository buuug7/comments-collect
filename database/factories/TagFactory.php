<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    $name = implode(' ', $faker->unique()->words(2));
    return [
        'name' => $name,
        'slug' => str_slug($name),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});
