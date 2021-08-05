<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DataRoleFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \BristolSU\ControlDB\Models\DataRole::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'role_name' => $this->faker->jobTitle,
            'email' => $this->faker->unique()->email
        ];
    }
}
