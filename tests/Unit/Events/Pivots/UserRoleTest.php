<?php

namespace BristolSU\Tests\ControlDB\Unit\Events\Pivots;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Events\Pivots\UserRole\UserAddedToRole;
use BristolSU\ControlDB\Events\Pivots\UserRole\UserRoleEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\UserRole\UserRemovedFromRole;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;
use Prophecy\Argument;

class UserRoleTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function userAddedToRole_event_can_be_created_and_data_retrieved(){
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $event = new UserAddedToRole($user, $role);

        $this->assertTrue($user->is($event->user));
        $this->assertTrue($role->is($event->role));
    }

    /** @test */
    public function userRemovedFromRole_event_can_be_created_and_data_retrieved(){
        $user = User::factory()->create();
        $role = Role::factory()->create();

        $event = new UserRemovedFromRole($user, $role);

        $this->assertTrue($user->is($event->user));
        $this->assertTrue($role->is($event->role));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getUsersThroughRole(){
        $role = Role::factory()->create();
        $users = User::factory()->count(10)->create();

        $baseUserRoleRepo = $this->prophesize(UserRole::class);
        $baseUserRoleRepo->getUsersThroughRole(Argument::that(fn($arg) => $arg instanceof Role && $arg->is($role)))
            ->shouldBeCalled()->willReturn($users);

        $eventDispatcher = new UserRoleEventDispatcher($baseUserRoleRepo->reveal());
        $allUsers = $eventDispatcher->getUsersThroughRole($role);
        $this->assertCount(10, $allUsers);
        foreach($allUsers as $user) {
            $this->assertTrue($users->shift()->is($user));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getRolesThroughUser(){
        $roles = Role::factory()->count(10)->create();
        $user = User::factory()->create();

        $baseUserRoleRepo = $this->prophesize(UserRole::class);
        $baseUserRoleRepo->getRolesThroughUser(Argument::that(fn($arg) => $arg instanceof User && $arg->is($user)))
            ->shouldBeCalled()->willReturn($roles);

        $eventDispatcher = new UserRoleEventDispatcher($baseUserRoleRepo->reveal());
        $allRoles = $eventDispatcher->getRolesThroughUser($user);
        $this->assertCount(10, $allRoles);
        foreach($allRoles as $role) {
            $this->assertTrue($roles->shift()->is($role));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_addUserToRole_and_it_dispatches_an_event(){
        $role = Role::factory()->create();
        $user = User::factory()->create();

        $baseUserRoleRepo = $this->prophesize(UserRole::class);
        $baseUserRoleRepo->addUserToRole(
            Argument::that(fn($arg) => $arg instanceof User && $arg->is($user)),
            Argument::that(fn($arg) => $arg instanceof Role && $arg->is($role))
        )->shouldBeCalled();

        $eventDispatcher = new UserRoleEventDispatcher($baseUserRoleRepo->reveal());
        $eventDispatcher->addUserToRole($user, $role);

        Event::assertDispatched(
            UserAddedToRole::class,
            fn(UserAddedToRole $event) => $user->is($event->user) && $role->is($event->role)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_removeUserFromRole_and_it_dispatches_an_event(){
        $role = Role::factory()->create();
        $user = User::factory()->create();

        $baseUserRoleRepo = $this->prophesize(UserRole::class);
        $baseUserRoleRepo->removeUserFromRole(
            Argument::that(fn($arg) => $arg instanceof User && $arg->is($user)),
            Argument::that(fn($arg) => $arg instanceof Role && $arg->is($role))
        )->shouldBeCalled();

        $eventDispatcher = new UserRoleEventDispatcher($baseUserRoleRepo->reveal());
        $eventDispatcher->removeUserFromRole($user, $role);

        Event::assertDispatched(
            UserRemovedFromRole::class,
            fn(UserRemovedFromRole $event) => $user->is($event->user) && $role->is($event->role)
        );
    }

}
