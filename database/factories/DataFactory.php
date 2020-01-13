<?php

$factory->define(\BristolSU\ControlDB\Models\DataUser::class, function(\Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->email,
        'dob' => $faker->dateTime,
        'preferred_name' => $faker->name
    ];
});

$factory->define(\BristolSU\ControlDB\Models\DataGroup::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->company,
        'email' => $faker->unique()->companyEmail
    ];
});

$factory->define(\BristolSU\ControlDB\Models\DataPosition::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->unique()->company,
        'description' => $faker->paragraph
    ];
});

$factory->define(\BristolSU\ControlDB\Models\DataRole::class, function(\Faker\Generator $faker) {
    return [
        'position_name' => $faker->jobTitle,
        'email' => $faker->unique()->email
    ];
});