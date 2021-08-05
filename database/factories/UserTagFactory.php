<?php

namespace Database\Factories;

use BristolSU\ControlDB\Models\Tags\UserTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTagFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserTag::class;

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
            'tag_category_id' => fn() => \BristolSU\ControlDB\Models\Tags\UserTagCategory::factory()->create()->id()
        ];
    }
}
