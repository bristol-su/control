<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DataUserFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \BristolSU\ControlDB\Models\DataUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->email,
            'dob' => $this->faker->dateTime,
            'preferred_name' => $this->faker->name
        ];
    }
}
