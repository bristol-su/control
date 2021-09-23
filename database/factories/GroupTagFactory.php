<?php

namespace Database\Factories;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupTagFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupTag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'reference' => $this->faker->word,
            'tag_category_id' => fn() => \BristolSU\ControlDB\Models\Tags\GroupTagCategory::factory()->create()->id()
        ];
    }
}
