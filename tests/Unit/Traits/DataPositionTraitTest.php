<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Position;
use BristolSU\Tests\ControlDB\TestCase;

class DataPositionTraitTest extends TestCase
{
    /** @test */
    public function position_returns_the_position(){
        $dataPosition = DataPosition::factory()->create();
        $position = Position::factory()->create(['data_provider_id' => $dataPosition->id()]);

        $this->assertInstanceOf(Position::class, $dataPosition->position());
        $this->assertTrue($position->is($dataPosition->position()));
    }

    /** @test */
    public function it_returns_null_if_no_position_found(){
        $dataPosition = DataPosition::factory()->create();
        $this->assertNull($dataPosition->position());
    }

    /** @test */
    public function setName_updates_the_name()
    {
        $dataPosition = DataPosition::factory()->create(['description' => 'description']);
        $dataPositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class);
        $dataPositionRepo->update($dataPosition->id(), 'NewName', 'description')->shouldBeCalled()->willReturn($dataPosition);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class, $dataPositionRepo->reveal());

        $dataPosition->setName('NewName');
    }

    /** @test */
    public function setDescription_updates_the_description()
    {
        $dataPosition = DataPosition::factory()->create(['name' => 'name1']);
        $dataPositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class);
        $dataPositionRepo->update($dataPosition->id(), 'name1', 'description2')->shouldBeCalled()->willReturn($dataPosition);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class, $dataPositionRepo->reveal());

        $dataPosition->setDescription('description2');
    }
}
