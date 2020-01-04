<?php

namespace BristolSU\Tests\ControlDB\Integration\Models\Tags;

use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagCategoryTest extends TestCase
{

    /** @test */
    public function it_uses_the_global_scope_to_only_return_role_tag_categories(){
        $roleTagCategory = factory(RoleTagCategory::class)->create();
        $userTagCategory = factory(UserTagCategory::class)->create();

        $this->assertEquals(1, RoleTagCategory::all()->count());
        $this->assertTrue($roleTagCategory->is(RoleTagCategory::first()));
    }

}
