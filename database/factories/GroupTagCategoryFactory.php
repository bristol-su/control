<?php

namespace Database\Factories;

use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupTagCategoryFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GroupTagCategory::class;

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
            'type' => 'group'
        ];
    }
}
