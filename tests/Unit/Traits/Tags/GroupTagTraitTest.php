<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits\Tags;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\DB;

class GroupTagTraitTest extends TestCase
{
    /** @test */
    public function category_returns_the_owning_category(){
        $groupTagCategory = factory(GroupTagCategory::class)->create();
        $groupTag = factory(GroupTag::class)->create(['tag_category_id' => $groupTagCategory->id]);

        $this->assertInstanceOf(GroupTagCategory::class, $groupTag->category());
        $this->assertTrue($groupTagCategory->is($groupTag->category()));
    }

    /** @test */
    public function groups_can_be_added_to_the_tag(){
        $groupTag = factory(GroupTag::class)->create();
        $taggedGroups = factory(Group::class, 5)->create();

        foreach($taggedGroups as $group) {
            $groupTag->addGroup($group);
        }

        $groupGroupRelationship = $groupTag->groups();
        $this->assertEquals(5, $groupGroupRelationship->count());
        foreach($taggedGroups as $group) {
            $this->assertTrue($group->is($groupGroupRelationship->shift()));
        }
    }

    /** @test */
    public function groups_can_be_removed_from_the_tag(){
        $groupTag = factory(GroupTag::class)->create();
        $taggedGroups = factory(Group::class, 5)->create();

        DB::table('control_taggables')->insert($taggedGroups->map(function($group) use ($groupTag) {
            return ['tag_id' => $groupTag->id, 'taggable_id' => $group->id, 'taggable_type' => 'group'];
        })->toArray());

        $groupGroupRelationship = $groupTag->groups();
        $this->assertEquals(5, $groupGroupRelationship->count());
        foreach($taggedGroups as $group) {
            $this->assertTrue($group->is($groupGroupRelationship->shift()));
        }

        foreach($taggedGroups as $group) {
            $groupTag->removeGroup($group);
        }

        $groupGroupRelationship = $groupTag->groups();
        $this->assertEquals(0, $groupGroupRelationship->count());
    }

    /** @test */
    public function group_returns_all_groups_tagged(){
        $groupTag = factory(GroupTag::class)->create();
        // Models which could be linked to a tag. Users, roles and positions should never be returned
        $taggedGroups = factory(Group::class, 5)->create();
        $untaggedGroups = factory(Group::class, 5)->create();
        $users = factory(User::class, 5)->create();
        $roles = factory(Role::class, 5)->create();
        $positions = factory(Position::class, 5)->create();

        DB::table('control_taggables')->insert($taggedGroups->map(function($group) use ($groupTag) {
            return ['tag_id' => $groupTag->id, 'taggable_id' => $group->id, 'taggable_type' => 'group'];
        })->toArray());

        $groupGroupRelationship = $groupTag->groups();
        $this->assertEquals(5, $groupGroupRelationship->count());
        foreach($taggedGroups as $group) {
            $this->assertTrue($group->is($groupGroupRelationship->shift()));
        }
    }

    /** @test */
    public function fullReference_returns_the_category_reference_and_the_tag_reference(){
        $groupTagCategory = factory(GroupTagCategory::class)->create(['reference' => 'categoryreference1']);
        $groupTag = factory(GroupTag::class)->create(['reference' => 'tagreference1', 'tag_category_id' => $groupTagCategory->id]);

        $this->assertEquals('categoryreference1.tagreference1', $groupTag->fullReference());
    }

    /** @test */
    public function setName_updates_the_group_tag_name()
    {
        $groupTag = factory(GroupTag::class)->create();

        $groupTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag::class);
        $groupTagRepository->update($groupTag->id(), 'NewName', $groupTag->description(), $groupTag->reference(), $groupTag->categoryId())
            ->shouldBeCalled()->willReturn($groupTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag::class, $groupTagRepository->reveal());

        $groupTag->setName('NewName');
    }

    /** @test */
    public function setDescription_updates_the_group_tag_description()
    {
        $groupTag = factory(GroupTag::class)->create();

        $groupTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag::class);
        $groupTagRepository->update($groupTag->id(), $groupTag->name(), 'NewDescription', $groupTag->reference(), $groupTag->categoryId())
            ->shouldBeCalled()->willReturn($groupTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag::class, $groupTagRepository->reveal());

        $groupTag->setDescription('NewDescription');
    }

    /** @test */
    public function setReference_updates_the_group_tag_reference()
    {
        $groupTag = factory(GroupTag::class)->create();

        $groupTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag::class);
        $groupTagRepository->update($groupTag->id(), $groupTag->name(), $groupTag->description(), 'NewReference', $groupTag->categoryId())
            ->shouldBeCalled()->willReturn($groupTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag::class, $groupTagRepository->reveal());

        $groupTag->setReference('NewReference');
    }

    /** @test */
    public function setTagCategoryId_updates_the_group_tag_category_id()
    {
        $groupTag = factory(GroupTag::class)->create();
        $groupTagCategory = factory(GroupTagCategory::class)->create();

        $groupTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag::class);
        $groupTagRepository->update($groupTag->id(), $groupTag->name(), $groupTag->description(), $groupTag->reference(), $groupTagCategory->id())
            ->shouldBeCalled()->willReturn($groupTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag::class, $groupTagRepository->reveal());

        $groupTag->setTagCategoryId($groupTagCategory->id());
    }

}