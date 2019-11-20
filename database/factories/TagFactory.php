<?php

$factory->define(\BristolSU\ControlDB\Models\Tags\GroupTag::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'reference' => $faker->word,
        'tag_category_id' => function() {
            return factory(\BristolSU\ControlDB\Models\Tags\GroupTagCategory::class)->create()->id;
        }
    ];
});

$factory->define(\BristolSU\ControlDB\Models\Tags\RoleTag::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'reference' => $faker->word,
        'tag_category_id' => function() {
            return factory(\BristolSU\ControlDB\Models\Tags\RoleTagCategory::class)->create()->id;
        }
    ];
});

$factory->define(\BristolSU\ControlDB\Models\Tags\PositionTag::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'reference' => $faker->word,
        'tag_category_id' => function() {
            return factory(\BristolSU\ControlDB\Models\Tags\PositionTagCategory::class)->create()->id;
        }
    ];
});

$factory->define(\BristolSU\ControlDB\Models\Tags\UserTag::class, function(\Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph,
        'reference' => $faker->word,
        'tag_category_id' => function() {
            return factory(\BristolSU\ControlDB\Models\Tags\UserTagCategory::class)->create()->id;
        }
    ];
});