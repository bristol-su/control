<?php

namespace BristolSU\Tests\ControlDB\Integration\Models\Tags;

use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagCategoryTest extends TestCase
{

    /** @test */
    public function it_uses_the_global_scope_to_only_return_group_tag_categories(){
        $groupTagCategory = factory(GroupTagCategory::class)->create();
        $userTagCategory = factory(UserTagCategory::class)->create();

        $this->assertEquals(1, UserTagCategory::all()->count());
        $this->assertTrue($userTagCategory->is(UserTagCategory::first()));
    }

}
