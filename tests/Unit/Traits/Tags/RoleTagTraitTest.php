<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits\Tags;

use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\DB;

class RoleTagTraitTest extends TestCase
{
    /** @test */
    public function category_returns_the_owning_category(){
        $roleTagCategory = factory(RoleTagCategory::class)->create();
        $roleTag = factory(RoleTag::class)->create(['tag_category_id' => $roleTagCategory->id]);

        $this->assertInstanceOf(RoleTagCategory::class, $roleTag->category());
        $this->assertTrue($roleTagCategory->is($roleTag->category()));
    }

    /** @test */
    public function roles_can_be_added_to_the_tag(){
        $roleTag = factory(RoleTag::class)->create();
        $taggedRoles = factory(Role::class, 5)->create();

        foreach($taggedRoles as $role) {
            $roleTag->addRole($role);
        }

        $roleRoleRelationship = $roleTag->roles();
        $this->assertEquals(5, $roleRoleRelationship->count());
        foreach($taggedRoles as $role) {
            $this->assertTrue($role->is($roleRoleRelationship->shift()));
        }
    }

    /** @test */
    public function roles_can_be_removed_from_the_tag(){
        $roleTag = factory(RoleTag::class)->create();
        $taggedRoles = factory(Role::class, 5)->create();

        DB::table('control_taggables')->insert($taggedRoles->map(function($role) use ($roleTag) {
            return ['tag_id' => $roleTag->id, 'taggable_id' => $role->id, 'taggable_type' => 'role'];
        })->toArray());

        $roleRoleRelationship = $roleTag->roles();
        $this->assertEquals(5, $roleRoleRelationship->count());
        foreach($taggedRoles as $role) {
            $this->assertTrue($role->is($roleRoleRelationship->shift()));
        }

        foreach($taggedRoles as $role) {
            $roleTag->removeRole($role);
        }

        $roleRoleRelationship = $roleTag->roles();
        $this->assertEquals(0, $roleRoleRelationship->count());
    }

    /** @test */
    public function role_returns_all_roles_tagged(){
        $roleTag = factory(RoleTag::class)->create();
        // Models which could be linked to a tag. Users, positions and roles should never be returned
        $taggedRoles = factory(Role::class, 5)->create();
        $untaggedRoles = factory(Role::class, 5)->create();
        $users = factory(User::class, 5)->create();
        $positions = factory(Position::class, 5)->create();
        $roles = factory(Role::class, 5)->create();

        DB::table('control_taggables')->insert($taggedRoles->map(function($role) use ($roleTag) {
            return ['tag_id' => $roleTag->id, 'taggable_id' => $role->id, 'taggable_type' => 'role'];
        })->toArray());

        $roleRoleRelationship = $roleTag->roles();
        $this->assertEquals(5, $roleRoleRelationship->count());
        foreach($taggedRoles as $role) {
            $this->assertTrue($role->is($roleRoleRelationship->shift()));
        }
    }

    /** @test */
    public function fullReference_returns_the_category_reference_and_the_tag_reference(){
        $roleTagCategory = factory(RoleTagCategory::class)->create(['reference' => 'categoryreference1']);
        $roleTag = factory(RoleTag::class)->create(['reference' => 'tagreference1', 'tag_category_id' => $roleTagCategory->id]);

        $this->assertEquals('categoryreference1.tagreference1', $roleTag->fullReference());
    }


    /** @test */
    public function setName_updates_the_role_tag_name()
    {
        $roleTag = factory(RoleTag::class)->create();

        $roleTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag::class);
        $roleTagRepository->update($roleTag->id(), 'NewName', $roleTag->description(), $roleTag->reference(), $roleTag->categoryId())
            ->shouldBeCalled()->willReturn($roleTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag::class, $roleTagRepository->reveal());

        $roleTag->setName('NewName');
    }

    /** @test */
    public function setDescription_updates_the_role_tag_description()
    {
        $roleTag = factory(RoleTag::class)->create();

        $roleTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag::class);
        $roleTagRepository->update($roleTag->id(), $roleTag->name(), 'NewDescription', $roleTag->reference(), $roleTag->categoryId())
            ->shouldBeCalled()->willReturn($roleTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag::class, $roleTagRepository->reveal());

        $roleTag->setDescription('NewDescription');
    }

    /** @test */
    public function setReference_updates_the_role_tag_reference()
    {
        $roleTag = factory(RoleTag::class)->create();

        $roleTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag::class);
        $roleTagRepository->update($roleTag->id(), $roleTag->name(), $roleTag->description(), 'NewReference', $roleTag->categoryId())
            ->shouldBeCalled()->willReturn($roleTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag::class, $roleTagRepository->reveal());

        $roleTag->setReference('NewReference');
    }

    /** @test */
    public function setTagCategoryId_updates_the_role_tag_category_id()
    {
        $roleTag = factory(RoleTag::class)->create();
        $roleTagCategory = factory(RoleTagCategory::class)->create();

        $roleTagRepository = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag::class);
        $roleTagRepository->update($roleTag->id(), $roleTag->name(), $roleTag->description(), $roleTag->reference(), $roleTagCategory->id())
            ->shouldBeCalled()->willReturn($roleTag);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag::class, $roleTagRepository->reveal());

        $roleTag->setTagCategoryId($roleTagCategory->id());
    }
}