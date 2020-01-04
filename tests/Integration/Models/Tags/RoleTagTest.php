<?php

namespace BristolSU\Tests\ControlDB\Integration\Models\Tags;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagTest extends TestCase
{

    /** @test */
    public function it_uses_the_global_scope_to_only_return_role_tags(){
        $roleTag = factory(RoleTag::class)->create();
        $groupTag = factory(GroupTag::class)->create();

        $this->assertEquals(1, RoleTag::all()->count());
        $this->assertTrue($roleTag->is(RoleTag::first()));
    }

}
