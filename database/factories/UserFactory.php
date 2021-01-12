<?php

namespace Database\Factories;

$factory->define(\BristolSU\ControlDB\Models\User::class, function(\Faker\Generator $faker) {
    return [
        'data_provider_id' => function() {
            return factory(\BristolSU\ControlDB\Models\DataUser::class)->create()->id;
        },
    ];
});
