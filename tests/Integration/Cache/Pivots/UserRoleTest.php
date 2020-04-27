<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Pivots;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class UserRoleTest extends TestCase
{

    /** @test */
    public function addUserToRole_does_not_save_in_cache()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $userRoleRepository = $this->prophesize(UserRole::class);
        $userRoleRepository->addUserToRole(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }), Argument::that(function ($arg) use ($role) {
            return $arg instanceof Role && $arg->is($role);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleTagCache = new \BristolSU\ControlDB\Cache\Pivots\UserRole($userRoleRepository->reveal(), $cache->reveal());

        $roleTagCache->addUserToRole($user, $role);
    }

    /** @test */
    public function removeUserFromRole_does_not_save_in_cache()
    {
        $user = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $userRoleRepository = $this->prophesize(UserRole::class);
        $userRoleRepository->removeUserFromRole(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }), Argument::that(function ($arg) use ($role) {
            return $arg instanceof Role && $arg->is($role);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleTagCache = new \BristolSU\ControlDB\Cache\Pivots\UserRole($userRoleRepository->reveal(), $cache->reveal());

        $roleTagCache->removeUserFromRole($user, $role);
    }

    /** @test */
    public function getUsersThroughRole_saves_the_users_in_the_cache()
    {
        $users = factory(User::class, 5)->create();
        $role = factory(Role::class)->create();

        $userRoleRepository = $this->prophesize(UserRole::class);
        $userRoleRepository->getUsersThroughRole(Argument::that(function ($arg) use ($role) {
            return $arg instanceof Role && $arg->is($role);
        }))->shouldBeCalled()->willReturn($users);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\UserRole::class . '@getUsersThroughRole:' . $role->id();

        $roleTagCache = new \BristolSU\ControlDB\Cache\Pivots\UserRole($userRoleRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $roleTagCache->getUsersThroughRole($role));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(User::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }

    /** @test */
    public function getRolesThroughUser_saves_the_roles_in_the_cache()
    {
        $roles = factory(Role::class, 5)->create();
        $user = factory(User::class)->create();

        $userRoleRepository = $this->prophesize(UserRole::class);
        $userRoleRepository->getRolesThroughUser(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }))->shouldBeCalled()->willReturn($roles);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\UserRole::class . '@getRolesThroughUser:' . $user->id();

        $userTagCache = new \BristolSU\ControlDB\Cache\Pivots\UserRole($userRoleRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $userTagCache->getRolesThroughUser($user));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(Role::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }
        

}