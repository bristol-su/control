<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Repositories\Pivots\Tags\RoleRoleTag as RoleRoleTagRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Collection;

class RoleRoleTagTest extends TestCase
{
    
    /** @test */
    public function it_gets_all_tags_through_a_role(){
        $role = factory(Role::class)->create();
        $roleTagsForRole = factory(RoleTag::class, 10)->create();
        $roleTagsNotForRole = factory(RoleTag::class, 10)->create();
        
        foreach($roleTagsForRole as $roleTag) {
            RoleRoleTag::create(['tag_id' => $roleTag->id(), 'taggable_id' => $role->id()]);
        }
        
        $roleRoleTag = new RoleRoleTagRepository();
        $retrievedRoleTags = $roleRoleTag->getTagsThroughRole($role);
        
        $this->assertEquals(10, $retrievedRoleTags->count());
        $this->assertContainsOnlyInstancesOf(RoleTag::class, $retrievedRoleTags);
        foreach($roleTagsForRole as $roleTag) {
            $this->assertTrue($roleTag->is($retrievedRoleTags->shift()));
        }
    }
    
    /** @test */
    public function it_gets_all_roles_tagged_with_a_tag(){
        $roleTag = factory(RoleTag::class)->create();
        $rolesForRoleTag = factory(Role::class, 10)->create();
        $rolesNotForRoleTag = factory(Role::class, 10)->create();

        foreach($rolesForRoleTag as $role) {
            RoleRoleTag::create(['tag_id' => $roleTag->id(), 'taggable_id' => $role->id()]);
        }

        $roleRoleTag = new RoleRoleTagRepository();
        $retrievedRoles = $roleRoleTag->getRolesThroughTag($roleTag);

        $this->assertEquals(10, $retrievedRoles->count());
        $this->assertContainsOnlyInstancesOf(Role::class, $retrievedRoles);
        foreach($rolesForRoleTag as $role) {
            $this->assertTrue($role->is($retrievedRoles->shift()));
        }
    }
    
    

    /** @test */
    public function addTagToRole_adds_a_tag_to_a_role()
    {
        $role = factory(Role::class)->create();
        $roleTag = factory(RoleTag::class)->create();

        $roleRoleTag = new \BristolSU\ControlDB\Repositories\Pivots\Tags\RoleRoleTag();
        $this->assertEquals(0, $roleRoleTag->getTagsThroughRole($role)->count());

        $roleRoleTag->addTagToRole($roleTag, $role);

        $this->assertEquals(1, $roleRoleTag->getTagsThroughRole($role)->count());
        $this->assertInstanceOf(RoleTag::class, $roleRoleTag->getTagsThroughRole($role)->first());
        $this->assertTrue($roleTag->is($roleRoleTag->getTagsThroughRole($role)->first()));
    }

    /** @test */
    public function removeTagFromRole_removes_a_tag_from_a_role()
    {
        $role = factory(Role::class)->create();
        $roleTag = factory(RoleTag::class)->create();
        $roleRoleTag = new \BristolSU\ControlDB\Repositories\Pivots\Tags\RoleRoleTag();
        RoleRoleTag::create([
            'taggable_id' => $role->id(), 'tag_id' => $roleTag->id()
        ]);
        $this->assertEquals(1, $roleRoleTag->getTagsThroughRole($role)->count());
        $this->assertInstanceOf(RoleTag::class, $roleRoleTag->getTagsThroughRole($role)->first());
        $this->assertTrue($roleTag->is($roleRoleTag->getTagsThroughRole($role)->first()));

        $roleRoleTag->removeTagFromRole($roleTag, $role);
    
        $this->assertEquals(0, $roleRoleTag->getTagsThroughRole($role)->count());
    }
}