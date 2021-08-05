<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DataGroupFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \BristolSU\ControlDB\Models\DataGroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company,
            'email' => $this->faker->unique()->companyEmail
        ];
    }
}
