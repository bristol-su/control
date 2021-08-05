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
        $userTagCategory = UserTagCategory::factory()->create();
        $userTag = UserTag::factory()->create(['tag_category_id' => $userTagCategory->id]);

        $this->assertInstanceOf(UserTagCategory::class, $userTag->category());
        $this->assertTrue($userTagCategory->is($userTag->category()));
    }

    /** @test */
    public function users_can_be_added_to_the_tag(){
        $userTag = UserTag::factory()->create();
        $taggedUsers = User::factory()->count(5)->create();

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
        $userTag = UserTag::factory()->create();
        $taggedUsers = User::factory()->count(5)->create();

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
        $userTag = UserTag::factory()->create();
        // Models which could be linked to a tag. Positions, roles and groups should never be returned
        $taggedUsers = User::factory()->count(5)->create();
        $untaggedUsers = User::factory()->count(5)->create();
        $positions = Position::factory()->count(5)->create();
        $roles = Role::factory()->count(5)->create();
        $groups = Group::factory()->count(5)->create();

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
        $userTagCategory = UserTagCategory::factory()->create(['reference' => 'categoryreference1']);
        $userTag = UserTag::factory()->create(['reference' => 'tagreference1', 'tag_category_id' => $userTagCategory->id]);

        $this->assertEquals('categoryreference1.tagreference1', $userTag->fullReference());
    }


    /** @test */
    public function setName_updates_the_user_tag_name()
    {
        $userTag = UserTag::factory()->create();

        $userTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag::class);
        $userTagRepository->update($userTag->id(), 'NewName', $userTag->description(), $userTag->reference(), $userTag->categoryId())
            ->shouldBeCalled()->willReturn($userTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag::class, $userTagRepository->reveal());

        $userTag->setName('NewName');
    }

    /** @test */
    public function setDescription_updates_the_user_tag_description()
    {
        $userTag = UserTag::factory()->create();

        $userTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag::class);
        $userTagRepository->update($userTag->id(), $userTag->name(), 'NewDescription', $userTag->reference(), $userTag->categoryId())
            ->shouldBeCalled()->willReturn($userTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag::class, $userTagRepository->reveal());

        $userTag->setDescription('NewDescription');
    }

    /** @test */
    public function setReference_updates_the_user_tag_reference()
    {
        $userTag = UserTag::factory()->create();

        $userTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag::class);
        $userTagRepository->update($userTag->id(), $userTag->name(), $userTag->description(), 'NewReference', $userTag->categoryId())
            ->shouldBeCalled()->willReturn($userTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag::class, $userTagRepository->reveal());

        $userTag->setReference('NewReference');
    }

    /** @test */
    public function setTagCategoryId_updates_the_user_tag_category_id()
    {
        $userTag = UserTag::factory()->create();
        $userTagCategory = UserTagCategory::factory()->create();

        $userTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag::class);
        $userTagRepository->update($userTag->id(), $userTag->name(), $userTag->description(), $userTag->reference(), $userTagCategory->id())
            ->shouldBeCalled()->willReturn($userTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag::class, $userTagRepository->reveal());

        $userTag->setTagCategoryId($userTagCategory->id());
    }

}
