<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \BristolSU\ControlDB\Models\Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'data_provider_id' => fn() => \BristolSU\ControlDB\Models\DataRole::factory()->create()->id(),
            'position_id' => fn() => \BristolSU\ControlDB\Models\Position::factory()->create()->id(),
            'group_id' => fn() => \BristolSU\ControlDB\Models\Group::factory()->create()->id()
        ];
    }
}
