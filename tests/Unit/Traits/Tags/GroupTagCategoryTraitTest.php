<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits\Tags;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagCategoryTraitTest extends TestCase
{
    /** @test */
    public function tags_returns_the_linked_tags(){
        $tagCategory1 = GroupTagCategory::factory()->create();
        $tags1 = GroupTag::factory()->count(5)->create(['tag_category_id' => $tagCategory1->id]);
        // Data that shouldn't be returned
        $tagCategory2 = GroupTagCategory::factory()->create();
        $tags2 = GroupTag::factory()->count(5)->create(['tag_category_id' => $tagCategory2->id]);

        $tagsFromRelationship = $tagCategory1->tags();
        $this->assertEquals(5, $tagsFromRelationship->count());
        foreach($tags1 as $tag) {
            $this->assertTrue($tag->is($tagsFromRelationship->shift()));
        }
    }

    /** @test */
    public function setName_updates_the_group_tag_category_name()
    {
        $groupTagCategory = GroupTagCategory::factory()->create();

        $groupTagCategoryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory::class);
        $groupTagCategoryRepository->update($groupTagCategory->id(), 'NewName', $groupTagCategory->description(), $groupTagCategory->reference())
            ->shouldBeCalled()->willReturn($groupTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory::class, $groupTagCategoryRepository->reveal());

        $groupTagCategory->setName('NewName');
    }

    /** @test */
    public function setDescription_updates_the_group_tag_category_description()
    {
        $groupTagCategory = GroupTagCategory::factory()->create();

        $groupTagCategoryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory::class);
        $groupTagCategoryRepository->update($groupTagCategory->id(), $groupTagCategory->name(), 'NewDescription', $groupTagCategory->reference())
            ->shouldBeCalled()->willReturn($groupTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory::class, $groupTagCategoryRepository->reveal());

        $groupTagCategory->setDescription('NewDescription');
    }

    /** @test */
    public function setReference_updates_the_group_tag_category_reference()
    {
        $groupTagCategory = GroupTagCategory::factory()->create();

        $groupTagCategoryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory::class);
        $groupTagCategoryRepository->update($groupTagCategory->id(), $groupTagCategory->name(), $groupTagCategory->description(), 'NewReference')
            ->shouldBeCalled()->willReturn($groupTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory::class, $groupTagCategoryRepository->reveal());

        $groupTagCategory->setReference('NewReference');
    }


}
