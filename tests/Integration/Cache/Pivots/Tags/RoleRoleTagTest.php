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

        $roleRoleTagRepository = $this->prophesize(RoleRoleTag::class);
        $roleRoleTagRepository->getTagsThroughRole(Argument::that(function ($arg) use ($role) {
            return $arg instanceof Role && $arg->is($role);
        }))->shouldBeCalled()->willReturn($roleTags);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag::class . '@getTagsThroughRole:' . $role->id();

        $roleRoleTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag($roleRoleTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $roleRoleTagCache->getTagsThroughRole($role));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(RoleTag::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }

    /** @test */
    public function getRolesThroughTag_saves_the_roles_in_the_cache()
    {
        $roles = Role::factory()->count(5)->create();
        $roleTag = RoleTag::factory()->create();

        $roleRoleTagRepository = $this->prophesize(RoleRoleTag::class);
        $roleRoleTagRepository->getRolesThroughTag(Argument::that(function ($arg) use ($roleTag) {
            return $arg instanceof RoleTag && $arg->is($roleTag);
        }))->shouldBeCalled()->willReturn($roles);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag::class . '@getRolesThroughTag:' . $roleTag->id();

        $roleTagTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag($roleRoleTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $roleTagTagCache->getRolesThroughTag($roleTag));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(Role::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }
}
