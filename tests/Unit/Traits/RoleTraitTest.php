<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\DB;

class RoleTraitTest extends TestCase
{

    /** @test */
    public function tags_can_be_saved_to_a_role(){
        $tags = factory(RoleTag::class, 5)->create();
        $role = factory(Role::class)->create();

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
        $roleTags = factory(RoleTag::class, 5)->create();
        $role = factory(Role::class)->create();

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
        $users = factory(User::class, 5)->create();
        $role = factory(Role::class)->create();

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
        $users = factory(User::class, 5)->create();
        $role = factory(Role::class)->create();

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
        $group = factory(Group::class)->create();
        $role = factory(Role::class)->create(['group_id' => $group->id]);

        $groupThroughRole = $role->group();
        $this->assertInstanceOf(Group::class, $groupThroughRole);
        $this->assertTrue($group->is($groupThroughRole));
    }

    /** @test */
    public function positions_returns_all_positions_associated_with_the_role(){
        $position = factory(Position::class)->create();
        $role = factory(Role::class)->create(['position_id' => $position->id]);

        $positionThroughRole = $role->position();
        $this->assertInstanceOf(Position::class, $positionThroughRole);
        $this->assertTrue($position->is($positionThroughRole));
    }
    
}