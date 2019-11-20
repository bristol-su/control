<?php

$factory->define(\BristolSU\ControlDB\Models\Group::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->company,
        'data_provider_id' => $faker->unique()->numberBetween(1, 9999999),
        'email' => $faker->unique()->email
    ];
});