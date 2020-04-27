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
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $userGroupRepository = $this->prophesize(UserGroup::class);
        $userGroupRepository->addUserToGroup(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }), Argument::that(function ($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupTagCache = new \BristolSU\ControlDB\Cache\Pivots\UserGroup($userGroupRepository->reveal(), $cache->reveal());

        $groupTagCache->addUserToGroup($user, $group);
    }

    /** @test */
    public function removeUserFromGroup_does_not_save_in_cache()
    {
        $user = factory(User::class)->create();
        $group = factory(Group::class)->create();

        $userGroupRepository = $this->prophesize(UserGroup::class);
        $userGroupRepository->removeUserFromGroup(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }), Argument::that(function ($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $groupTagCache = new \BristolSU\ControlDB\Cache\Pivots\UserGroup($userGroupRepository->reveal(), $cache->reveal());

        $groupTagCache->removeUserFromGroup($user, $group);
    }

    /** @test */
    public function getUsersThroughGroup_saves_the_users_in_the_cache()
    {
        $users = factory(User::class, 5)->create();
        $group = factory(Group::class)->create();

        $userGroupRepository = $this->prophesize(UserGroup::class);
        $userGroupRepository->getUsersThroughGroup(Argument::that(function ($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalled()->willReturn($users);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\UserGroup::class . '@getUsersThroughGroup:' . $group->id();

        $groupTagCache = new \BristolSU\ControlDB\Cache\Pivots\UserGroup($userGroupRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $groupTagCache->getUsersThroughGroup($group));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(User::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }

    /** @test */
    public function getGroupsThroughUser_saves_the_groups_in_the_cache()
    {
        $groups = factory(Group::class, 5)->create();
        $user = factory(User::class)->create();

        $userGroupRepository = $this->prophesize(UserGroup::class);
        $userGroupRepository->getGroupsThroughUser(Argument::that(function ($arg) use ($user) {
            return $arg instanceof User && $arg->is($user);
        }))->shouldBeCalled()->willReturn($groups);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\UserGroup::class . '@getGroupsThroughUser:' . $user->id();

        $userTagCache = new \BristolSU\ControlDB\Cache\Pivots\UserGroup($userGroupRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $userTagCache->getGroupsThroughUser($user));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(Group::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }
        

}