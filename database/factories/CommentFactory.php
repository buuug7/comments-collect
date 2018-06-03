<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'contents' => $faker->text(200),
        'commentable_id' => function () {
            return factory(\App\Post::class)->create()->id;
        },
        'commentable_type' => 'App\Post',
        'user_id' => function () {
            return factory(\App\User::class)->create()->id;
        },
        'target_user_id' => null,
        'target_comment_id' => null,
    ];
});
