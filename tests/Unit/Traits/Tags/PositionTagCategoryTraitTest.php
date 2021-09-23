<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits\Tags;

use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagCategoryTraitTest extends TestCase
{

    /** @test */
    public function tags_returns_the_linked_tags(){
        $tagCategory1 = PositionTagCategory::factory()->create();
        $tags1 = PositionTag::factory()->count(5)->create(['tag_category_id' => $tagCategory1->id]);
        // Data that shouldn't be returned
        $tagCategory2 = PositionTagCategory::factory()->create();
        $tags2 = PositionTag::factory()->count(5)->create(['tag_category_id' => $tagCategory2->id]);

        $tagsFromRelationship = $tagCategory1->tags();
        $this->assertEquals(5, $tagsFromRelationship->count());
        foreach($tags1 as $tag) {
            $this->assertTrue($tag->is($tagsFromRelationship->shift()));
        }
    }

    /** @test */
    public function setName_updates_the_position_tag_category_name()
    {
        $positionTagCategory = PositionTagCategory::factory()->create();

        $positionTagCategooryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory::class);
        $positionTagCategooryRepository->update($positionTagCategory->id(), 'NewName', $positionTagCategory->description(), $positionTagCategory->reference())
            ->shouldBeCalled()->willReturn($positionTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory::class, $positionTagCategooryRepository->reveal());

        $positionTagCategory->setName('NewName');
    }

    /** @test */
    public function setDescription_updates_the_position_tag_category_description()
    {
        $positionTagCategory = PositionTagCategory::factory()->create();

        $positionTagCategooryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory::class);
        $positionTagCategooryRepository->update($positionTagCategory->id(), $positionTagCategory->name(), 'NewDescription', $positionTagCategory->reference())
            ->shouldBeCalled()->willReturn($positionTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory::class, $positionTagCategooryRepository->reveal());

        $positionTagCategory->setDescription('NewDescription');
    }

    /** @test */
    public function setReference_updates_the_position_tag_category_reference()
    {
        $positionTagCategory = PositionTagCategory::factory()->create();

        $positionTagCategooryRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory::class);
        $positionTagCategooryRepository->update($positionTagCategory->id(), $positionTagCategory->name(), $positionTagCategory->description(), 'NewReference')
            ->shouldBeCalled()->willReturn($positionTagCategory);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory::class, $positionTagCategooryRepository->reveal());

        $positionTagCategory->setReference('NewReference');
    }
}
