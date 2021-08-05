<?php

namespace Database\Factories;

use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleTagCategoryFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RoleTagCategory::class;

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
            'type' => 'role'
        ];
    }
}
