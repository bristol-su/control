<?php

namespace Database\Factories;

$factory->define(\BristolSU\ControlDB\Models\Role::class, function(\Faker\Generator $faker) {
    return [
        'position_id' => function() {
            return factory(\BristolSU\ControlDB\Models\Position::class)->create()->id;
        },
        'group_id' => function() {
            return factory(\BristolSU\ControlDB\Models\Group::class)->create()->id;
        },
        'data_provider_id' => function() {
            return factory(\BristolSU\ControlDB\Models\DataRole::class)->create()->id;
        },
    ];
});
