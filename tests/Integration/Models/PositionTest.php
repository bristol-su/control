<?php

namespace BristolSU\Tests\ControlDB\Integration\Models;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Position;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTest extends TestCase
{

    /** @test */
    public function the_data_function_returns_the_data_model(){
        $dataPosition = factory(DataPosition::class)->create();
        $position = factory(Position::class)->create(['data_provider_id' => $dataPosition->id()]);
        
        $this->assertInstanceOf(DataPosition::class, $position->data());
        $this->assertTrue($dataPosition->is(
            $position->data()
        ));
    }

}