<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \BristolSU\ControlDB\Models\Position::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'data_provider_id' => fn() => \BristolSU\ControlDB\Models\DataPosition::factory()->create()->id()
        ];
    }
}
