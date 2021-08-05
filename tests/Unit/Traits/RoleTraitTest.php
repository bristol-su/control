<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\DB;

class RoleTraitTest extends TestCase
{

    /** @test */
    public function data_returns_the_data_attribute_for_the_role(){
        $dataRole = DataRole::factory()->create();
        $role = Role::factory()->create(['data_provider_id' => $dataRole->id()]);

        $this->assertInstanceOf(DataRole::class, $role->data());
        $this->assertTrue($dataRole->is($role->data()));
    }

    /** @test */
    public function users_can_be_removed_from_a_role() {
        $users = User::factory()->count(5)->create();
        $role = Role::factory()->create();

        foreach($users as $user) {
            $role->addUser($user);
        }

        foreach($users as $user) {
            $this->assertDatabaseHas('control_role_user', [
                'role_id' => $role->id, 'user_id' => $user->id
            ]);
        }

        foreach($users as $user) {
            $role->removeUser($user);
        }

        foreach($users as $user) {
            $this->assertSoftDeleted('control_role_user', [
                'role_id' => $role->id, 'user_id' => $user->id
            ]);
        }
    }

    /** @test */
    public function tags_can_be_removed_from_a_role() {
        $tags = RoleTag::factory()->count(5)->create();
        $role = Role::factory()->create();

        foreach($tags as $tag) {
            $role->addTag($tag);
        }

        foreach($tags as $tag) {
            $this->assertDatabaseHas('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $role->id,
                'taggable_type' => 'role'
            ]);
        }

        foreach($tags as $tag) {
            $role->removeTag($tag);
        }

        foreach($tags as $tag) {
            $this->assertSoftDeleted('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $role->id,
                'taggable_type' => 'role'
            ]);
        }
    }
    /** @test */
    public function tags_can_be_saved_to_a_role(){
        $tags = RoleTag::factory()->count(5)->create();
        $role = Role::factory()->create();

        foreach($tags as $tag) {
            $role->addTag($tag);
        }

        foreach($tags as $tag) {
            $this->assertDatabaseHas('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $role->id,
                'taggable_type' => 'role'
            ]);
        }
    }

    /** @test */
    public function tags_returns_all_tags_associated_with_the_role(){
        $roleTags = RoleTag::factory()->count(5)->create();
        $role = Role::factory()->create();

        DB::table('control_taggables')->insert($roleTags->map(function($roleTag) use ($role) {
            return ['tag_id' => $roleTag->id, 'taggable_id' => $role->id, 'taggable_type' => 'role'];
        })->toArray());

        $tags = $role->tags();
        $this->assertEquals(5, $tags->count());
        foreach($roleTags as $tag) {
            $this->assertTrue($tag->is($tags->shift()));
        }
    }

    /** @test */
    public function users_can_be_added_to_a_role(){
        $users = User::factory()->count(5)->create();
        $role = Role::factory()->create();

        foreach($users as $user) {
            $role->addUser($user);
        }

        foreach($users as $user) {
            $this->assertDatabaseHas('control_role_user', [
                'user_id' => $user->id,
                'role_id' => $role->id,
            ]);
            $this->assertDatabaseHas('control_users', ['id' => $user->id]);
        }
    }

    /** @test */
    public function users_returns_all_users_associated_with_the_role(){
        $users = User::factory()->count(5)->create();
        $role = Role::factory()->create();

        DB::table('control_role_user')->insert($users->map(function($user) use ($role) {
            return ['user_id' => $user->id, 'role_id' => $role->id];
        })->toArray());

        $usersThroughRole = $role->users();
        $this->assertEquals(5, $usersThroughRole->count());
        foreach($users as $user) {
            $this->assertTrue($user->is($usersThroughRole->shift()));
        }
    }

    /** @test */
    public function groups_returns_all_groups_associated_with_the_role(){
        $group = Group::factory()->create();
        $role = Role::factory()->create(['group_id' => $group->id]);

        $groupThroughRole = $role->group();
        $this->assertInstanceOf(Group::class, $groupThroughRole);
        $this->assertTrue($group->is($groupThroughRole));
    }

    /** @test */
    public function positions_returns_all_positions_associated_with_the_role(){
        $position = Position::factory()->create();
        $role = Role::factory()->create(['position_id' => $position->id]);

        $positionThroughRole = $role->position();
        $this->assertInstanceOf(Position::class, $positionThroughRole);
        $this->assertTrue($position->is($positionThroughRole));
    }

    /** @test */
    public function setDataProviderId_updates_the_data_provider_id()
    {
        $oldDataRole = DataRole::factory()->create();
        $newDataRole = DataRole::factory()->create();
        $role = Role::factory()->create(['data_provider_id' => $oldDataRole->id()]);

        $roleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $roleRepo->update($role->id(), $role->positionId(), $role->groupId(), $newDataRole->id())->shouldBeCalled()->willReturn($role);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Role::class, $roleRepo->reveal());

        $role->setDataProviderId($newDataRole->id());
    }

    /** @test */
    public function setGroupId_updates_the_group_id()
    {
        $oldGroup = Group::factory()->create();
        $newGroup = Group::factory()->create();
        $role = Role::factory()->create(['group_id' => $oldGroup->id()]);

        $roleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $roleRepo->update($role->id(), $role->positionId(), $newGroup->id(), $role->dataProviderId())->shouldBeCalled()->willReturn($role);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Role::class, $roleRepo->reveal());

        $role->setGroupId($newGroup->id());
    }

    /** @test */
    public function setPositionId_updates_the_position_id()
    {
        $oldPosition = Position::factory()->create();
        $newPosition = Position::factory()->create();
        $role = Role::factory()->create(['position_id' => $oldPosition->id()]);

        $roleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $roleRepo->update($role->id(), $newPosition->id(), $role->groupId(), $role->dataProviderId())->shouldBeCalled()->willReturn($role);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Role::class, $roleRepo->reveal());

        $role->setPositionId($newPosition->id());
    }
}
