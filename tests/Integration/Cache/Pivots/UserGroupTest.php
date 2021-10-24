<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Pivots;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class UserGroupTest extends TestCase
{

    /** @test */
    public function addUserToGroup_does_not_save_in_cache()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $userGroupRepository = $this->prophesize(UserGroup::class);
        $userGroupRepository->addUserToGroup(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }), Argument::that(function ($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userGroupCache = new \BristolSU\ControlDB\Cache\Pivots\UserGroup($userGroupRepository->reveal(), $cache->reveal());

        $userGroupCache->addUserToGroup($user, $group);
    }

    /** @test */
    public function removeUserFromGroup_does_not_save_in_cache()
    {
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $userGroupRepository = $this->prophesize(UserGroup::class);
        $userGroupRepository->removeUserFromGroup(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }), Argument::that(function ($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userGroupCache = new \BristolSU\ControlDB\Cache\Pivots\UserGroup($userGroupRepository->reveal(), $cache->reveal());

        $userGroupCache->removeUserFromGroup($user, $group);
    }

    /** @test */
    public function getUsersThroughGroup_saves_the_users_in_the_cache()
    {
        $users = User::factory()->count(5)->create();
        $group = Group::factory()->create();

        $userGroupRepository = $this->prophesize(UserGroup::class);
        $userGroupRepository->getUsersThroughGroup(Argument::that(function ($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalledTimes(1)->willReturn($users);

        $userGroupCache = new \BristolSU\ControlDB\Cache\Pivots\UserGroup($userGroupRepository->reveal(), app(Repository::class));

        $assertUsers = function($users) {
            $this->assertInstanceOf(Collection::class, $users);
            $this->assertContainsOnlyInstancesOf(User::class, $users);
            $this->assertCount(5, $users);
        };

        // The underlying instance should only be called once
        $assertUsers($userGroupCache->getUsersThroughGroup($group));
        $assertUsers($userGroupCache->getUsersThroughGroup($group));
    }

    /** @test */
    public function getGroupsThroughUser_saves_the_groups_in_the_cache()
    {
        $groups = Group::factory()->count(5)->create();
        $user = User::factory()->create();

        $userGroupRepository = $this->prophesize(UserGroup::class);
        $userGroupRepository->getGroupsThroughUser(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }))->shouldBeCalledTimes(1)->willReturn($groups);

        $userTagCache = new \BristolSU\ControlDB\Cache\Pivots\UserGroup($userGroupRepository->reveal(), app(Repository::class));

        $assertGroups = function($groups) {
            $this->assertInstanceOf(Collection::class, $groups);
            $this->assertContainsOnlyInstancesOf(Group::class, $groups);
            $this->assertCount(5, $groups);
        };

        // The underlying instance should only be called once
        $assertGroups($userTagCache->getGroupsThroughUser($user));
        $assertGroups($userTagCache->getGroupsThroughUser($user));
    }


}
