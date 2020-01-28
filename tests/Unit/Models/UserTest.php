<?php

namespace BristolSU\Tests\ControlDB\Unit\Models;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\User;
use Illuminate\Support\Facades\DB;
use BristolSU\Tests\ControlDB\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function id_returns_the_id_of_the_user(){
        $user = factory(User::class)->create();
        
        $this->assertEquals($user->id, $user->id());
    }

    /** @test */
    public function tags_can_be_added_to_a_user(){
        $tags = factory(UserTag::class, 5)->create();
        $user = factory(User::class)->create();

        foreach($tags as $tag) {
            $user->addTag($tag);
        }

        foreach($tags as $tag) {
            $this->assertDatabaseHas('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $user->id,
                'taggable_type' => 'user'
            ]);
        }
    }

    /** @test */
    public function tags_returns_all_tags_associated_with_the_user(){
        $userTags = factory(UserTag::class, 5)->create();
        $user = factory(User::class)->create();

        DB::table('control_taggables')->insert($userTags->map(function($userTag) use ($user) {
            return ['tag_id' => $userTag->id, 'taggable_id' => $user->id, 'taggable_type' => 'user'];
        })->toArray());

        $tags = $user->tags();
        $this->assertEquals(5, $tags->count());
        foreach($userTags as $tag) {
            $this->assertTrue($tag->is($tags->shift()));
        }
    }


    /** @test */
    public function roles_returns_all_roles_belonging_to_the_user() {
        $roles = factory(Role::class, 5)->create();
        $user = factory(User::class)->create();

        DB::table('control_role_user')->insert($roles->map(function($role) use ($user) {
            return ['role_id' => $role->id, 'user_id' => $user->id];
        })->toArray());

        $members = $user->roles();
        $this->assertEquals(5, $members->count());
        foreach($roles as $role) {
            $this->assertTrue($role->is($members->shift()));
        }
    }

    /** @test */
    public function roleRelationship_can_be_used_to_add_a_role_to_a_user() {
        $roles = factory(Role::class, 5)->create();
        $user = factory(User::class)->create();

        foreach($roles as $role) {
            $user->addRole($role);
        }

        foreach($roles as $role) {
            $this->assertDatabaseHas('control_role_user', [
                'user_id' => $user->id, 'role_id' => $role->id
            ]);
        }
    }

    /** @test */
    public function groups_returns_all_groups_belonging_to_the_user(){
        $groups = factory(Group::class, 5)->create();
        $user = factory(User::class)->create();

        DB::table('control_group_user')->insert($groups->map(function($group) use ($user) {
            return ['group_id' => $group->id, 'user_id' => $user->id];
        })->toArray());

        $groups = $user->groups();
        $this->assertEquals(5, $groups->count());
        foreach($groups as $group) {
            $this->assertTrue($group->is($groups->shift()));
        }
    }
    

    /** @test */
    public function groups_can_be_added_to_a_user() {
        $groups = factory(Group::class, 5)->create();
        $user = factory(User::class)->create();

        foreach($groups as $group) {
            $user->addGroup($group);
        }

        foreach($groups as $group) {
            $this->assertDatabaseHas('control_group_user', [
                'user_id' => $user->id, 'group_id' => $group->id
            ]);
        }
    }
    
    /** @test */
    public function dataProviderId_returns_the_data_provider_id_of_the_model(){
        $user = factory(User::class)->create(['data_provider_id' => 5]);
        
        $this->assertEquals(5, $user->dataProviderId());
    }

}
