<?php

$factory->define(\App\Application::class, function (Faker\Generator $faker) {
    $name = $faker->name;

    return [
        'name' => $name,
        'slack_channel' => '#' . Str::slug($name),
        'jira_projectcode' => strtoupper($faker->word),
        'github_repository' => 'IN10/' . Str::slug($name),
    ];
});
