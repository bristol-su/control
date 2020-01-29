<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits\Tags;

use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Models\Position;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\DB;

class UserTagTraitTest extends TestCase
{
    /** @test */
    public function category_returns_the_owning_category(){
        $userTagCategory = factory(UserTagCategory::class)->create();
        $userTag = factory(UserTag::class)->create(['tag_category_id' => $userTagCategory->id]);

        $this->assertInstanceOf(UserTagCategory::class, $userTag->category());
        $this->assertTrue($userTagCategory->is($userTag->category()));
    }

    /** @test */
    public function users_can_be_added_to_the_tag(){
        $userTag = factory(UserTag::class)->create();
        $taggedUsers = factory(User::class, 5)->create();

        foreach($taggedUsers as $user) {
            $userTag->addUser($user);
        }

        $userUserRelationship = $userTag->users();
        $this->assertEquals(5, $userUserRelationship->count());
        foreach($taggedUsers as $user) {
            $this->assertTrue($user->is($userUserRelationship->shift()));
        }
    }

    /** @test */
    public function users_can_be_removed_from_the_tag(){
        $userTag = factory(UserTag::class)->create();
        $taggedUsers = factory(User::class, 5)->create();

        DB::table('control_taggables')->insert($taggedUsers->map(function($user) use ($userTag) {
            return ['tag_id' => $userTag->id, 'taggable_id' => $user->id, 'taggable_type' => 'user'];
        })->toArray());

        $userUserRelationship = $userTag->users();
        $this->assertEquals(5, $userUserRelationship->count());
        foreach($taggedUsers as $user) {
            $this->assertTrue($user->is($userUserRelationship->shift()));
        }

        foreach($taggedUsers as $user) {
            $userTag->removeUser($user);
        }

        $userUserRelationship = $userTag->users();
        $this->assertEquals(0, $userUserRelationship->count());
    }

    /** @test */
    public function user_returns_all_users_tagged(){
        $userTag = factory(UserTag::class)->create();
        // Models which could be linked to a tag. Positions, roles and groups should never be returned
        $taggedUsers = factory(User::class, 5)->create();
        $untaggedUsers = factory(User::class, 5)->create();
        $positions = factory(Position::class, 5)->create();
        $roles = factory(Role::class, 5)->create();
        $groups = factory(Group::class, 5)->create();

        DB::table('control_taggables')->insert($taggedUsers->map(function($user) use ($userTag) {
            return ['tag_id' => $userTag->id, 'taggable_id' => $user->id, 'taggable_type' => 'user'];
        })->toArray());

        $userUserRelationship = $userTag->users();
        $this->assertEquals(5, $userUserRelationship->count());
        foreach($taggedUsers as $user) {
            $this->assertTrue($user->is($userUserRelationship->shift()));
        }
    }

    /** @test */
    public function fullReference_returns_the_category_reference_and_the_tag_reference(){
        $userTagCategory = factory(UserTagCategory::class)->create(['reference' => 'categoryreference1']);
        $userTag = factory(UserTag::class)->create(['reference' => 'tagreference1', 'tag_category_id' => $userTagCategory->id]);

        $this->assertEquals('categoryreference1.tagreference1', $userTag->fullReference());
    }

}