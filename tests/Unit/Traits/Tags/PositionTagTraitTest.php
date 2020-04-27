<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits\Tags;

use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\DB;

class PositionTagTraitTest extends TestCase
{
    /** @test */
    public function category_returns_the_owning_category(){
        $positionTagCategory = factory(PositionTagCategory::class)->create();
        $positionTag = factory(PositionTag::class)->create(['tag_category_id' => $positionTagCategory->id]);

        $this->assertInstanceOf(PositionTagCategory::class, $positionTag->category());
        $this->assertTrue($positionTagCategory->is($positionTag->category()));
    }

    /** @test */
    public function positions_can_be_added_to_the_tag(){
        $positionTag = factory(PositionTag::class)->create();
        $taggedPositions = factory(Position::class, 5)->create();

        foreach($taggedPositions as $position) {
            $positionTag->addPosition($position);
        }

        $positionPositionRelationship = $positionTag->positions();
        $this->assertEquals(5, $positionPositionRelationship->count());
        foreach($taggedPositions as $position) {
            $this->assertTrue($position->is($positionPositionRelationship->shift()));
        }
    }

    /** @test */
    public function positions_can_be_removed_from_the_tag(){
        $positionTag = factory(PositionTag::class)->create();
        $taggedPositions = factory(Position::class, 5)->create();

        DB::table('control_taggables')->insert($taggedPositions->map(function($position) use ($positionTag) {
            return ['tag_id' => $positionTag->id, 'taggable_id' => $position->id, 'taggable_type' => 'position'];
        })->toArray());

        $positionPositionRelationship = $positionTag->positions();
        $this->assertEquals(5, $positionPositionRelationship->count());
        foreach($taggedPositions as $position) {
            $this->assertTrue($position->is($positionPositionRelationship->shift()));    
        }

        foreach($taggedPositions as $position) {
            $positionTag->removePosition($position);
        }

        $positionPositionRelationship = $positionTag->positions();
        $this->assertEquals(0, $positionPositionRelationship->count());
    }

    /** @test */
    public function position_returns_all_positions_tagged(){
        $positionTag = factory(PositionTag::class)->create();
        // Models which could be linked to a tag. Users, roles and groups should never be returned
        $taggedPositions = factory(Position::class, 5)->create();
        $untaggedPositions = factory(Position::class, 5)->create();
        $users = factory(User::class, 5)->create();
        $roles = factory(Role::class, 5)->create();
        $groups = factory(Group::class, 5)->create();

        DB::table('control_taggables')->insert($taggedPositions->map(function($position) use ($positionTag) {
            return ['tag_id' => $positionTag->id, 'taggable_id' => $position->id, 'taggable_type' => 'position'];
        })->toArray());

        $positionPositionRelationship = $positionTag->positions();
        $this->assertEquals(5, $positionPositionRelationship->count());
        foreach($taggedPositions as $position) {
            $this->assertTrue($position->is($positionPositionRelationship->shift()));
        }
    }

    /** @test */
    public function fullReference_returns_the_category_reference_and_the_tag_reference(){
        $positionTagCategory = factory(PositionTagCategory::class)->create(['reference' => 'categoryreference1']);
        $positionTag = factory(PositionTag::class)->create(['reference' => 'tagreference1', 'tag_category_id' => $positionTagCategory->id]);

        $this->assertEquals('categoryreference1.tagreference1', $positionTag->fullReference());
    }


    /** @test */
    public function setName_updates_the_position_tag_name()
    {
        $positionTag = factory(PositionTag::class)->create();

        $positionTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag::class);
        $positionTagRepository->update($positionTag->id(), 'NewName', $positionTag->description(), $positionTag->reference(), $positionTag->categoryId())
            ->shouldBeCalled()->willReturn($positionTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag::class, $positionTagRepository->reveal());

        $positionTag->setName('NewName');
    }

    /** @test */
    public function setDescription_updates_the_position_tag_description()
    {
        $positionTag = factory(PositionTag::class)->create();

        $positionTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag::class);
        $positionTagRepository->update($positionTag->id(), $positionTag->name(), 'NewDescription', $positionTag->reference(), $positionTag->categoryId())
            ->shouldBeCalled()->willReturn($positionTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag::class, $positionTagRepository->reveal());

        $positionTag->setDescription('NewDescription');
    }

    /** @test */
    public function setReference_updates_the_position_tag_reference()
    {
        $positionTag = factory(PositionTag::class)->create();

        $positionTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag::class);
        $positionTagRepository->update($positionTag->id(), $positionTag->name(), $positionTag->description(), 'NewReference', $positionTag->categoryId())
            ->shouldBeCalled()->willReturn($positionTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag::class, $positionTagRepository->reveal());

        $positionTag->setReference('NewReference');
    }

    /** @test */
    public function setTagCategoryId_updates_the_position_tag_category_id()
    {
        $positionTag = factory(PositionTag::class)->create();
        $positionTagCategory = factory(PositionTagCategory::class)->create();

        $positionTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag::class);
        $positionTagRepository->update($positionTag->id(), $positionTag->name(), $positionTag->description(), $positionTag->reference(), $positionTagCategory->id())
            ->shouldBeCalled()->willReturn($positionTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag::class, $positionTagRepository->reveal());

        $positionTag->setTagCategoryId($positionTagCategory->id());
    }

}