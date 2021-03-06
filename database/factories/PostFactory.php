<?php

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'body' => $faker->paragraph,
        'user_id' => $faker->numberBetween(5, 10)
    ];
});
