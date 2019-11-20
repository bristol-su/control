<?php

$factory->define(\BristolSU\ControlDB\Models\User::class, function(\Faker\Generator $faker) {
    return [
        'data_provider_id' => $faker->numberBetween(1, 9999999)
    ];
});