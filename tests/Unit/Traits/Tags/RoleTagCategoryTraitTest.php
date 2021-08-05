<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits\Tags;

use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagCategoryTraitTest extends TestCase
{
    /** @test */
    public function tags_returns_the_linked_tags(){
        $tagCategory1 = RoleTagCategory::factory()->create();
        $tags1 = RoleTag::factory()->count(5)->create(['tag_category_id' => $tagCategory1->id]);
        // Data that shouldn't be returned
        $tagCategory2 = RoleTagCategory::factory()->create();
        $tags2 = RoleTag::factory()->count(5)->create(['tag_category_id' => $tagCategory2->id]);

        $tagsFromRelationship = $tagCategory1->tags();
        $this->assertEquals(5, $tagsFromRelationship->count());
        foreach($tags1 as $tag) {
            $this->assertTrue($tag->is($tagsFromRelationship->shift()));
        }
    }

    /** @test */
    public function setName_updates_the_role_tag_category_name()
    {
        $roleTagCategory = RoleTagCategory::factory()->create();

        $roleTagCategooryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory::class);
        $roleTagCategooryRepository->update($roleTagCategory->id(), 'NewName', $roleTagCategory->description(), $roleTagCategory->reference())
            ->shouldBeCalled()->willReturn($roleTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory::class, $roleTagCategooryRepository->reveal());

        $roleTagCategory->setName('NewName');
    }

    /** @test */
    public function setDescription_updates_the_role_tag_category_description()
    {
        $roleTagCategory = RoleTagCategory::factory()->create();

        $roleTagCategooryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory::class);
        $roleTagCategooryRepository->update($roleTagCategory->id(), $roleTagCategory->name(), 'NewDescription', $roleTagCategory->reference())
            ->shouldBeCalled()->willReturn($roleTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory::class, $roleTagCategooryRepository->reveal());

        $roleTagCategory->setDescription('NewDescription');
    }

    /** @test */
    public function setReference_updates_the_role_tag_category_reference()
    {
        $roleTagCategory = RoleTagCategory::factory()->create();

        $roleTagCategooryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory::class);
        $roleTagCategooryRepository->update($roleTagCategory->id(), $roleTagCategory->name(), $roleTagCategory->description(), 'NewReference')
            ->shouldBeCalled()->willReturn($roleTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory::class, $roleTagCategooryRepository->reveal());

        $roleTagCategory->setReference('NewReference');
    }
}
