<?php

namespace BristolSU\Tests\ControlDB\Integration\Models\Tags;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagTest extends TestCase
{

    /** @test */
    public function it_uses_the_global_scope_to_only_return_user_tags(){
        $userTag = factory(UserTag::class)->create();
        $groupTag = factory(GroupTag::class)->create();

        $this->assertEquals(1, UserTag::all()->count());
        $this->assertTrue($userTag->is(UserTag::first()));
    }

}
