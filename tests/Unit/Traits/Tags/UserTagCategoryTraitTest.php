<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits\Tags;

use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagCategoryTraitTest extends TestCase
{

    /** @test */
    public function tags_returns_the_linked_tags(){
        $tagCategory1 = factory(UserTagCategory::class)->create();
        $tags1 = factory(UserTag::class, 5)->create(['tag_category_id' => $tagCategory1->id]);
        // Data that shouldn't be returned
        $tagCategory2 = factory(UserTagCategory::class)->create();
        $tags2 = factory(UserTag::class, 5)->create(['tag_category_id' => $tagCategory2->id]);

        $tagsFromRelationship = $tagCategory1->tags();
        $this->assertEquals(5, $tagsFromRelationship->count());
        foreach($tags1 as $tag) {
            $this->assertTrue($tag->is($tagsFromRelationship->shift()));
        }
    }

    /** @test */
    public function setName_updates_the_user_tag_category_name()
    {
        $userTagCategory = factory(UserTagCategory::class)->create();

        $userTagCategooryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory::class);
        $userTagCategooryRepository->update($userTagCategory->id(), 'NewName', $userTagCategory->description(), $userTagCategory->reference())
            ->shouldBeCalled()->willReturn($userTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory::class, $userTagCategooryRepository->reveal());

        $userTagCategory->setName('NewName');
    }

    /** @test */
    public function setDescription_updates_the_user_tag_category_description()
    {
        $userTagCategory = factory(UserTagCategory::class)->create();

        $userTagCategooryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory::class);
        $userTagCategooryRepository->update($userTagCategory->id(), $userTagCategory->name(), 'NewDescription', $userTagCategory->reference())
            ->shouldBeCalled()->willReturn($userTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory::class, $userTagCategooryRepository->reveal());

        $userTagCategory->setDescription('NewDescription');
    }

    /** @test */
    public function setReference_updates_the_user_tag_category_reference()
    {
        $userTagCategory = factory(UserTagCategory::class)->create();

        $userTagCategooryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory::class);
        $userTagCategooryRepository->update($userTagCategory->id(), $userTagCategory->name(), $userTagCategory->description(), 'NewReference')
            ->shouldBeCalled()->willReturn($userTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory::class, $userTagCategooryRepository->reveal());

        $userTagCategory->setReference('NewReference');
    }
}