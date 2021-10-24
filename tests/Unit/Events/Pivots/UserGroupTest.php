<?php

namespace BristolSU\Tests\ControlDB\Unit\Events\Pivots;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Events\Pivots\UserGroup\UserAddedToGroup;
use BristolSU\ControlDB\Events\Pivots\UserGroup\UserGroupEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\UserGroup\UserRemovedFromGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;
use Prophecy\Argument;

class UserGroupTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function userAddedToGroup_event_can_be_created_and_data_retrieved(){
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $event = new UserAddedToGroup($user, $group);

        $this->assertTrue($user->is($event->user));
        $this->assertTrue($group->is($event->group));
    }

    /** @test */
    public function userRemovedFromGroup_event_can_be_created_and_data_retrieved(){
        $user = User::factory()->create();
        $group = Group::factory()->create();

        $event = new UserRemovedFromGroup($user, $group);

        $this->assertTrue($user->is($event->user));
        $this->assertTrue($group->is($event->group));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getUsersThroughGroup(){
        $group = Group::factory()->create();
        $users = User::factory()->count(10)->create();

        $baseUserGroupRepo = $this->prophesize(UserGroup::class);
        $baseUserGroupRepo->getUsersThroughGroup(Argument::that(fn($arg) => $arg instanceof Group && $arg->is($group)))
            ->shouldBeCalled()->willReturn($users);

        $eventDispatcher = new UserGroupEventDispatcher($baseUserGroupRepo->reveal());
        $allUsers = $eventDispatcher->getUsersThroughGroup($group);
        $this->assertCount(10, $allUsers);
        foreach($allUsers as $user) {
            $this->assertTrue($users->shift()->is($user));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getGroupsThroughUser(){
        $groups = Group::factory()->count(10)->create();
        $user = User::factory()->create();

        $baseUserGroupRepo = $this->prophesize(UserGroup::class);
        $baseUserGroupRepo->getGroupsThroughUser(Argument::that(fn($arg) => $arg instanceof User && $arg->is($user)))
            ->shouldBeCalled()->willReturn($groups);

        $eventDispatcher = new UserGroupEventDispatcher($baseUserGroupRepo->reveal());
        $allGroups = $eventDispatcher->getGroupsThroughUser($user);
        $this->assertCount(10, $allGroups);
        foreach($allGroups as $group) {
            $this->assertTrue($groups->shift()->is($group));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_addUserToGroup_and_it_dispatches_an_event(){
        $group = Group::factory()->create();
        $user = User::factory()->create();

        $baseUserGroupRepo = $this->prophesize(UserGroup::class);
        $baseUserGroupRepo->addUserToGroup(
            Argument::that(fn($arg) => $arg instanceof User && $arg->is($user)),
            Argument::that(fn($arg) => $arg instanceof Group && $arg->is($group))
        )->shouldBeCalled();

        $eventDispatcher = new UserGroupEventDispatcher($baseUserGroupRepo->reveal());
        $eventDispatcher->addUserToGroup($user, $group);

        Event::assertDispatched(
            UserAddedToGroup::class,
            fn(UserAddedToGroup $event) => $user->is($event->user) && $group->is($event->group)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_removeUserFromGroup_and_it_dispatches_an_event(){
        $group = Group::factory()->create();
        $user = User::factory()->create();

        $baseUserGroupRepo = $this->prophesize(UserGroup::class);
        $baseUserGroupRepo->removeUserFromGroup(
            Argument::that(fn($arg) => $arg instanceof User && $arg->is($user)),
            Argument::that(fn($arg) => $arg instanceof Group && $arg->is($group))
        )->shouldBeCalled();

        $eventDispatcher = new UserGroupEventDispatcher($baseUserGroupRepo->reveal());
        $eventDispatcher->removeUserFromGroup($user, $group);

        Event::assertDispatched(
            UserRemovedFromGroup::class,
            fn(UserRemovedFromGroup $event) => $user->is($event->user) && $group->is($event->group)
        );
    }

}
