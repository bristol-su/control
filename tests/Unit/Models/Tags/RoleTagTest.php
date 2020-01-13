<?php


namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;


use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\User;
use Illuminate\Support\Facades\DB;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagTest extends TestCase
{
    // TODO Test name method
    // TODO Test description method
    // TODO Test reference method
    // TODO Test categoryId method
    /** @test */
    public function it_has_an_id_attribute(){
        $roleTag = factory(RoleTag::class)->create(['id' => 1]);
        $this->assertEquals(1, $roleTag->id());
    }

    /** @test */
    public function category_relationship_returns_the_owning_category(){
        $roleTagCategory = factory(RoleTagCategory::class)->create();
        $roleTag = factory(RoleTag::class)->create(['tag_category_id' => $roleTagCategory->id]);

        $this->assertInstanceOf(RoleTagCategory::class, $roleTag->categoryRelationship);
        $this->assertTrue($roleTagCategory->is($roleTag->categoryRelationship));
    }

    /** @test */
    public function category_returns_the_owning_category(){
        $roleTagCategory = factory(RoleTagCategory::class)->create();
        $roleTag = factory(RoleTag::class)->create(['tag_category_id' => $roleTagCategory->id]);

        $this->assertInstanceOf(RoleTagCategory::class, $roleTag->category());
        $this->assertTrue($roleTagCategory->is($roleTag->category()));
    }


    /** @test */
    public function role_relationship_returns_roles_with_the_tag(){
        $roleTag = factory(RoleTag::class)->create();
        // Models which could be linked to a tag. Roles, roles and roles should never be returned
        $taggedRoles = factory(Role::class, 5)->create();
        $untaggedRoles = factory(Role::class, 5)->create();
        $groups = factory(Group::class, 5)->create();
        $positions = factory(Position::class, 5)->create();
        $users = factory(User::class, 5)->create();

        DB::table('control_taggables')->insert($taggedRoles->map(function($role) use ($roleTag) {
            return ['tag_id' => $roleTag->id, 'taggable_id' => $role->id, 'taggable_type' => 'role'];
        })->toArray());

        $roleRoleRelationship = $roleTag->roleRelationship;
        $this->assertEquals(5, $roleRoleRelationship->count());
        foreach($taggedRoles as $role) {
            $this->assertTrue($role->is($roleRoleRelationship->shift()));
        }
    }

    /** @test */
    public function role_relationship_can_be_used_to_tag_a_role(){
        $roleTag = factory(RoleTag::class)->create();

        $taggedRoles = factory(Role::class, 5)->make();
        $roleTag->roleRelationship()->saveMany($taggedRoles);

        $roleRoleRelationship = $roleTag->roleRelationship;
        $this->assertEquals(5, $roleRoleRelationship->count());
        foreach($taggedRoles as $role) {
            $this->assertTrue($role->is($roleRoleRelationship->shift()));
        }
    }

    /** @test */
    public function role_returns_all_roles_tagged(){
        $roleTag = factory(RoleTag::class)->create();
        // Models which could be linked to a tag. Roles, roles and roles should never be returned
        $taggedRoles = factory(Role::class, 5)->create();
        $untaggedRoles = factory(Role::class, 5)->create();
        $groups = factory(Group::class, 5)->create();
        $positions = factory(Position::class, 5)->create();
        $users = factory(User::class, 5)->create();

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

}
