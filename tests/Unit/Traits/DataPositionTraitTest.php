<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Position;
use BristolSU\Tests\ControlDB\TestCase;

class DataPositionTraitTest extends TestCase
{
    /** @test */
    public function position_returns_the_position(){
        $dataPosition = factory(DataPosition::class)->create();
        $position = factory(Position::class)->create(['data_provider_id' => $dataPosition->id()]);

        $this->assertInstanceOf(Position::class, $dataPosition->position());
        $this->assertTrue($position->is($dataPosition->position()));
    }

    /** @test */
    public function it_returns_null_if_no_position_found(){
        $dataPosition = factory(DataPosition::class)->create();
        $this->assertNull($dataPosition->position());
    }
}