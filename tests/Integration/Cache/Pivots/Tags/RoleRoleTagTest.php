<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class RoleRoleTagTest extends TestCase
{
    /** @test */
    public function addTagToRole_does_not_save_in_cache()
    {
        $roleTag = RoleTag::factory()->create();
        $role = Role::factory()->create();

        $roleRoleTagRepository = $this->prophesize(RoleRoleTag::class);
        $roleRoleTagRepository->addTagToRole(Argument::that(function ($arg) use ($roleTag) {
            return $arg instanceof RoleTag && $arg->is($roleTag);
        }), Argument::that(function ($arg) use ($role) {
            return $arg instanceof Role && $arg->is($role);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleRoleTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag($roleRoleTagRepository->reveal(), $cache->reveal());

        $roleRoleTagCache->addTagToRole($roleTag, $role);
    }

    /** @test */
    public function removeTagFromRole_does_not_save_in_cache()
    {
        $roleTag = RoleTag::factory()->create();
        $role = Role::factory()->create();

        $roleRoleTagRepository = $this->prophesize(RoleRoleTag::class);
        $roleRoleTagRepository->removeTagFromRole(Argument::that(function ($arg) use ($roleTag) {
            return $arg instanceof RoleTag && $arg->is($roleTag);
        }), Argument::that(function ($arg) use ($role) {
            return $arg instanceof Role && $arg->is($role);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleRoleTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag($roleRoleTagRepository->reveal(), $cache->reveal());

        $roleRoleTagCache->removeTagFromRole($roleTag, $role);
    }

    /** @test */
    public function getTagsThroughRole_saves_the_tags_in_the_cache()
    {
        $roleTags = RoleTag::factory()->count(5)->create();
        $role = Role::factory()->create();

        $baseRoleRoleTagRepository = $this->prophesize(RoleRoleTag::class);
        $baseRoleRoleTagRepository->getTagsThroughRole(Argument::that(function ($arg) use ($role) {
            return $arg instanceof Role && $arg->is($role);
        }))->shouldBeCalledTimes(1)->willReturn($roleTags);

        $roleRoleTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag($baseRoleRoleTagRepository->reveal(), app(Repository::class));

        $assertRoleTags = function($roleTags) {
            $this->assertInstanceOf(Collection::class, $roleTags);
            $this->assertContainsOnlyInstancesOf(RoleTag::class, $roleTags);
            $this->assertCount(5, $roleTags);
        };

        // The underlying instance should only be called once
        $assertRoleTags($roleRoleTagCache->getTagsThroughRole($role));
        $assertRoleTags($roleRoleTagCache->getTagsThroughRole($role));
    }

    /** @test */
    public function getRolesThroughTag_saves_the_roles_in_the_cache()
    {
        $roles = Role::factory()->count(5)->create();
        $roleTag = RoleTag::factory()->create();

        $baseRoleRoleTagRepository = $this->prophesize(RoleRoleTag::class);
        $baseRoleRoleTagRepository->getRolesThroughTag(Argument::that(function ($arg) use ($roleTag) {
            return $arg instanceof RoleTag && $arg->is($roleTag);
        }))->shouldBeCalledTimes(1)->willReturn($roles);

        $roleRoleTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag($baseRoleRoleTagRepository->reveal(), app(Repository::class));

        $assertRoles = function($roles) {
            $this->assertInstanceOf(Collection::class, $roles);
            $this->assertContainsOnlyInstancesOf(Role::class, $roles);
            $this->assertCount(5, $roles);
        };

        // The underlying instance should only be called once
        $assertRoles($roleRoleTagCache->getRolesThroughTag($roleTag));
        $assertRoles($roleRoleTagCache->getRolesThroughTag($roleTag));

    }
}
