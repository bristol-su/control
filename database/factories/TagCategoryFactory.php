<?php

namespace Database\Factories;

$factory->define(\BristolSU\ControlDB\Models\Tags\GroupTagCategory::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'reference' => $faker->word,
        'type' => 'group'
    ];
});

$factory->define(\BristolSU\ControlDB\Models\Tags\UserTagCategory::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'reference' => $faker->word,
        'type' => 'user'
    ];
});

$factory->define(\BristolSU\ControlDB\Models\Tags\RoleTagCategory::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'reference' => $faker->word,
        'type' => 'role'
    ];
});

$factory->define(\BristolSU\ControlDB\Models\Tags\PositionTagCategory::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'reference' => $faker->word,
        'type' => 'position'
    ];
});
