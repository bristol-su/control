<?php

namespace BristolSU\Tests\ControlDB\Integration\Models\Tags;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagTest extends TestCase
{

    /** @test */
    public function it_uses_the_global_scope_to_only_return_position_tags(){
        $positionTag = factory(PositionTag::class)->create();
        $groupTag = factory(GroupTag::class)->create();

        $this->assertEquals(1, PositionTag::all()->count());
        $this->assertTrue($positionTag->is(PositionTag::first()));
    }

}
