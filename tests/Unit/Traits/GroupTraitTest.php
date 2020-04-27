<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\DB;

class GroupTraitTest extends TestCase
{

    /** @test */
    public function data_returns_the_data_attribute_for_the_group(){
        $dataGroup = factory(DataGroup::class)->create();
        $group = factory(Group::class)->create(['data_provider_id' => $dataGroup->id()]);

        $this->assertInstanceOf(DataGroup::class, $group->data());
        $this->assertTrue($dataGroup->is($group->data()));
    }

    /** @test */
    public function users_can_be_removed_from_a_group() {
        $users = factory(User::class, 5)->create();
        $group = factory(Group::class)->create();

        foreach($users as $user) {
            $group->addUser($user);
        }

        foreach($users as $user) {
            $this->assertDatabaseHas('control_group_user', [
                'group_id' => $group->id, 'user_id' => $user->id
            ]);
        }

        foreach($users as $user) {
            $group->removeUser($user);
        }

        foreach($users as $user) {
            $this->assertSoftDeleted('control_group_user', [
                'group_id' => $group->id, 'user_id' => $user->id
            ]);
        }
    }

    /** @test */
    public function tags_can_be_removed_from_a_group() {
        $tags = factory(GroupTag::class, 5)->create();
        $group = factory(Group::class)->create();

        foreach($tags as $tag) {
            $group->addTag($tag);
        }

        foreach($tags as $tag) {
            $this->assertDatabaseHas('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $group->id,
                'taggable_type' => 'group'
            ]);
        }

        foreach($tags as $tag) {
            $group->removeTag($tag);
        }

        foreach($tags as $tag) {
            $this->assertSoftDeleted('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $group->id,
                'taggable_type' => 'group'
            ]);
        }
    }
    
    /** @test */
    public function members_returns_all_users_belonging_to_the_group(){
        $users = factory(User::class, 5)->create();
        $group = factory(Group::class)->create();

        DB::table('control_group_user')->insert($users->map(function($user) use ($group) {
            return ['user_id' => $user->id, 'group_id' => $group->id];
        })->toArray());

        $members = $group->members();
        $this->assertEquals(5, $members->count());
        foreach($users as $user) {
            $this->assertTrue($user->is($members->shift()));
        }
    }

    /** @test */
    public function roles_returns_all_roles_belonging_to_the_group(){
        $group = factory(Group::class)->create();
        $roles = factory(Role::class, 5)->create(['group_id' => $group->id]);

        $groupRoles = $group->roles();
        $this->assertEquals(5, $groupRoles->count());
        foreach($roles as $role) {
            $this->assertTrue($role->is($groupRoles->shift()));
        }
    }

    /** @test */
    public function tags_returns_all_tags_belonging_to_the_group(){
        $groupTags = factory(GroupTag::class, 5)->create();
        $group = factory(Group::class)->create();

        DB::table('control_taggables')->insert($groupTags->map(function($groupTag) use ($group) {
            return ['tag_id' => $groupTag->id, 'taggable_id' => $group->id, 'taggable_type' => 'group'];
        })->toArray());

        $tags = $group->tags();
        $this->assertEquals(5, $tags->count());
        foreach($groupTags as $groupTag) {
            $this->assertTrue($groupTag->is($tags->shift()));
        }
    }

    /** @test */
    public function users_can_be_added_to_a_group() {
        $users = factory(User::class, 5)->create();
        $group = factory(Group::class)->create();

        foreach($users as $user) {
            $group->addUser($user);
        }

        foreach($users as $user) {
            $this->assertDatabaseHas('control_group_user', [
                'group_id' => $group->id, 'user_id' => $user->id
            ]);
        }
    }

    /** @test */
    public function tags_can_be_added_to_a_group() {
        $tags = factory(GroupTag::class, 5)->create();
        $group = factory(Group::class)->create();

        foreach($tags as $tag) {
            $group->addTag($tag);
        }

        foreach($tags as $tag) {
            $this->assertDatabaseHas('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $group->id,
                'taggable_type' => 'group'
            ]);
        }
    }

    /** @test */
    public function setDataProviderId_updates_the_data_provider_id()
    {
        $oldDataGroup = factory(DataGroup::class)->create();
        $newDataGroup = factory(DataGroup::class)->create();
        $group = factory(Group::class)->create(['data_provider_id' => $oldDataGroup->id()]);
        
        $groupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Group::class);
        $groupRepo->update($group->id(), $newDataGroup->id())->shouldBeCalled()->willReturn($group);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Group::class, $groupRepo->reveal());

        $group->setDataProviderId($newDataGroup->id());
    }
    
}