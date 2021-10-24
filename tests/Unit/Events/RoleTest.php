<?php

namespace BristolSU\Tests\ControlDB\Unit\Events;

use BristolSU\ControlDB\Events\Role\RoleDeleted;
use BristolSU\ControlDB\Events\Role\RoleEventDispatcher;
use BristolSU\ControlDB\Events\Role\RoleUpdated;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Events\Role\RoleCreated;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;

class RoleTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function roleCreated_event_can_be_created_and_data_retrieved(){
        $role = Role::factory()->create();
        $event = new RoleCreated($role);

        $this->assertTrue($role->is($event->role));
    }

    /** @test */
    public function roleUpdated_event_can_be_created_and_data_retrieved(){
        $role = Role::factory()->create();
        $event = new RoleUpdated($role, ['updated' => 'data']);

        $this->assertTrue($role->is($event->role));
        $this->assertEquals(['updated' => 'data'], $event->updatedData);
    }

    /** @test */
    public function roleDeleted_event_can_be_created_and_data_retrieved(){
        $role = Role::factory()->create();
        $event = new RoleDeleted($role);

        $this->assertTrue($role->is($event->role));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getById(){
        $role = Role::factory()->create();

        $baseRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $baseRoleRepo->getById(1)->shouldBeCalled()->willReturn($role);

        $eventDispatcher = new RoleEventDispatcher($baseRoleRepo->reveal());
        $this->assertTrue($role->is($eventDispatcher->getById(1)));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getByDataProviderId(){
        $role = Role::factory()->create();

        $baseRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $baseRoleRepo->getByDataProviderId(1)->shouldBeCalled()->willReturn($role);

        $eventDispatcher = new RoleEventDispatcher($baseRoleRepo->reveal());
        $this->assertTrue($role->is($eventDispatcher->getByDataProviderId(1)));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_all(){
        $roles = Role::factory()->count(10)->create();

        $baseRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $baseRoleRepo->all()->shouldBeCalled()->willReturn($roles);

        $eventDispatcher = new RoleEventDispatcher($baseRoleRepo->reveal());
        $allRoles = $eventDispatcher->all();
        $this->assertCount(10, $allRoles);
        foreach($allRoles as $role) {
            $this->assertTrue($roles->shift()->is($role));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_paginate(){
        $roles = Role::factory()->count(10)->create();

        $baseRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $baseRoleRepo->paginate(1, 10)->shouldBeCalled()->willReturn($roles);

        $eventDispatcher = new RoleEventDispatcher($baseRoleRepo->reveal());
        $allRoles = $eventDispatcher->paginate(1, 10);
        $this->assertCount(10, $allRoles);
        foreach($allRoles as $role) {
            $this->assertTrue($roles->shift()->is($role));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_count(){
        $baseRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $baseRoleRepo->count()->shouldBeCalled()->willReturn(5);

        $eventDispatcher = new RoleEventDispatcher($baseRoleRepo->reveal());
        $this->assertEquals(5, $eventDispatcher->count());
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_create_and_it_dispatches_an_event(){
        $role = Role::factory()->create();

        $baseRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $baseRoleRepo->create(1, 2, 3)->shouldBeCalled()->willReturn($role);

        $eventDispatcher = new RoleEventDispatcher($baseRoleRepo->reveal());
        $newRole = $eventDispatcher->create(1, 2, 3);
        $this->assertTrue($role->is($newRole));

        Event::assertDispatched(
            RoleCreated::class,
            fn(RoleCreated $event) => $event->role->is($role)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_update_and_it_dispatches_an_event(){
        $role = Role::factory()->create(['position_id' => 1, 'group_id' => 2, 'data_provider_id' => 3]);

        $baseRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $baseRoleRepo->getById($role->id())->willReturn($role);
        $baseRoleRepo->update($role->id(), 4, 5, 6)->shouldBeCalled()->willReturn($role);

        $eventDispatcher = new RoleEventDispatcher($baseRoleRepo->reveal());
        $newRole = $eventDispatcher->update($role->id(), 4, 5, 6);
        $this->assertTrue($role->is($newRole));

        Event::assertDispatched(
            RoleUpdated::class,
            fn(RoleUpdated $event) => $event->role->is($role) && $event->updatedData === ['position_id' => 4, 'group_id' => 5, 'data_provider_id' => 6]
        );
    }

    /** @test */
    public function for_update_updated_data_only_contains_updated_data(){
        $role = Role::factory()->create(['position_id' => 1, 'group_id' => 2, 'data_provider_id' => 3]);

        $baseRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Role::class);
        $baseRoleRepo->getById($role->id())->willReturn($role);
        $baseRoleRepo->update($role->id(), 1, 2, 6)->shouldBeCalled()->willReturn($role);

        $eventDispatcher = new RoleEventDispatcher($baseRoleRepo->reveal());
        $newRole = $eventDispatcher->update($role->id(), 1, 2, 6);
        $this->assertTrue($role->is($newRole));

        Event::assertDispatched(
            RoleUpdated::class,
            fn(RoleUpdated $event) => $event->role->is($role) && $event->updatedData === ['data_provider_id' => 6]
        );
    }

}
