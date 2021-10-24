<?php

namespace BristolSU\Tests\ControlDB\Unit\Models\Lazy;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Lazy\LazyPosition;
use BristolSU\ControlDB\Models\Position;
use BristolSU\Tests\ControlDB\TestCase;

class LazyPositionTest extends TestCase
{

    /** @test */
    public function an_id_can_be_retrieved_from_the_model()
    {
        $position = new LazyPosition(Position::factory()->create(['id' => 4])->id());

        $this->assertEquals(4, $position->id());
    }

    /** @test */
    public function a_data_provider_id_can_be_retrieved_from_the_model(){
        $position = Position::factory()->create([
            'data_provider_id' => 5
        ]);

        $this->assertEquals(5, $position->dataProviderId());
    }

    /** @test */
    public function a_data_provider_id_can_set_on_from_the_model(){
        $position = new LazyPosition(Position::factory()->create(['data_provider_id' => 1])->id());

        $position->setDataProviderId(5);

        $this->assertEquals(5, $position->dataProviderId());
    }

    /** @test */
    public function data_is_returned_in_the_array(){
        $dataPosition = DataPosition::factory()->create(
            ['name' => 'Position1', 'description' => 'description of the position']
        );
        $position = new LazyPosition(Position::factory()->create(['data_provider_id' => $dataPosition->id()])->id());

        $attributes = $position->toArray();
        $this->assertArrayHasKey('data', $attributes);
        $this->assertIsArray($attributes['data']);
        $this->assertArrayHasKey('name', $attributes['data']);
        $this->assertArrayHasKey('description', $attributes['data']);
        $this->assertEquals('Position1', $attributes['data']['name']);
        $this->assertEquals('description of the position', $attributes['data']['description']);
    }

}
