<?php

namespace BristolSU\Tests\ControlDB\Unit\Models;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Position;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTest extends TestCase
{

    /** @test */
    public function an_id_can_be_retrieved_from_the_model()
    {
        $position = factory(Position::class)->create([
            'id' => 4
        ]);

        $this->assertEquals(4, $position->id());
    }

    /** @test */
    public function a_data_provider_id_can_be_retrieved_from_the_model(){
        $position = factory(Position::class)->create([
            'data_provider_id' => 5
        ]);

        $this->assertEquals(5, $position->dataProviderId());
    }

    /** @test */
    public function a_data_provider_id_can_set_on_from_the_model(){
        $position = factory(Position::class)->create([
            'data_provider_id' => 5
        ]);

        $position->setDataProviderId(5);

        $this->assertEquals(5, $position->dataProviderId());
    }

    /** @test */
    public function data_is_returned_in_the_array(){
        $dataPosition = factory(DataPosition::class)->create(
            ['name' => 'Position1', 'description' => 'description of the position']
        );
        $position = factory(Position::class)->create([
            'data_provider_id' => $dataPosition->id()
        ]);

        $attributes = $position->toArray();
        $this->assertArrayHasKey('data', $attributes);
        $this->assertIsArray($attributes['data']);
        $this->assertArrayHasKey('name', $attributes['data']);
        $this->assertArrayHasKey('description', $attributes['data']);
        $this->assertEquals('Position1', $attributes['data']['name']);
        $this->assertEquals('description of the position', $attributes['data']['description']);
    }
}
