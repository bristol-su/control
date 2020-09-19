<?php

namespace Database\Factories;

$factory->define(\BristolSU\ControlDB\Models\Group::class, function(\Faker\Generator $faker) {
    return [
        'data_provider_id' => function() {
            return factory(\BristolSU\ControlDB\Models\DataGroup::class)->create()->id;
        },
    ];
});
