<?php

$factory->define(\BristolSU\ControlDB\Models\Position::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph
    ];
});