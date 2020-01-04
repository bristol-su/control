<?php

namespace BristolSU\Tests\ControlDB\Integration\Models\Tags;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagTest extends TestCase
{

    /** @test */
    public function it_uses_the_global_scope_to_only_return_group_tags(){
        $groupTag = factory(GroupTag::class)->create();
        $userTag = factory(UserTag::class)->create();

        $this->assertEquals(1, GroupTag::all()->count());
        $this->assertTrue($groupTag->is(GroupTag::first()));
    }

}
