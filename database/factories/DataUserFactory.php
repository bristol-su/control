<?php

$factory->define(\BristolSU\ControlDB\Models\DataUser::class, function(\Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'dob' => $faker->dateTime,
        'preferred_name' => $faker->name
    ];
});