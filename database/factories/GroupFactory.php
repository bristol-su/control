<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \BristolSU\ControlDB\Models\Group::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'data_provider_id' => fn() => \BristolSU\ControlDB\Models\DataGroup::factory()->create()->id()
        ];
    }
}
