<?php

$factory->define(\App\Deploy::class, function (Faker\Generator $faker) {
    return [
        'application_id' => function () {
            return factory(\App\Application::class)->create()->id;
        },
        'stage' => $faker->randomElement(\App\Stage::ALL),
        'sha1' => $faker->sha1,
        'username' => $faker->username,
    ];
});
