<?php

namespace Database\Factories;

$factory->define(\BristolSU\ControlDB\Models\Position::class, function(\Faker\Generator $faker) {
    return [
        'data_provider_id' => function() {
            return factory(\BristolSU\ControlDB\Models\DataPosition::class)->create()->id;
        },
    ];
});
