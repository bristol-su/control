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
        $user = User::factory()->create();
        $role = Role::factory()->create();

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
        $user = User::factory()->create();
        $role = Role::factory()->create();

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
        $users = User::factory()->count(5)->create();
        $role = Role::factory()->create();

        $userRoleRepository = $this->prophesize(UserRole::class);
        $userRoleRepository->getUsersThroughRole(Argument::that(function ($arg) use ($role) {
            return $arg instanceof Role && $arg->is($role);
        }))->shouldBeCalledTimes(1)->willReturn($users);

        $userRoleCache = new \BristolSU\ControlDB\Cache\Pivots\UserRole($userRoleRepository->reveal(), app(Repository::class));

        $assertUsers = function($users) {
            $this->assertInstanceOf(Collection::class, $users);
            $this->assertContainsOnlyInstancesOf(User::class, $users);
            $this->assertCount(5, $users);
        };

        // The underlying instance should only be called once
        $assertUsers($userRoleCache->getUsersThroughRole($role));
        $assertUsers($userRoleCache->getUsersThroughRole($role));
    }

    /** @test */
    public function getRolesThroughUser_saves_the_roles_in_the_cache()
    {
        $roles = Role::factory()->count(5)->create();
        $user = User::factory()->create();

        $userRoleRepository = $this->prophesize(UserRole::class);
        $userRoleRepository->getRolesThroughUser(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }))->shouldBeCalledTimes(1)->willReturn($roles);

        $userTagCache = new \BristolSU\ControlDB\Cache\Pivots\UserRole($userRoleRepository->reveal(), app(Repository::class));

        $assertRoles = function($roles) {
            $this->assertInstanceOf(Collection::class, $roles);
            $this->assertContainsOnlyInstancesOf(Role::class, $roles);
            $this->assertCount(5, $roles);
        };

        // The underlying instance should only be called once
        $assertRoles($userTagCache->getRolesThroughUser($user));
        $assertRoles($userTagCache->getRolesThroughUser($user));
    }


}
