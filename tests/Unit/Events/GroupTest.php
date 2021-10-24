<?php

namespace BristolSU\Tests\ControlDB\Unit\Events;

use BristolSU\ControlDB\Events\Group\GroupDeleted;
use BristolSU\ControlDB\Events\Group\GroupEventDispatcher;
use BristolSU\ControlDB\Events\Group\GroupUpdated;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Events\Group\GroupCreated;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;

class GroupTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function groupCreated_event_can_be_created_and_data_retrieved(){
        $group = Group::factory()->create();
        $event = new GroupCreated($group);

        $this->assertTrue($group->is($event->group));
    }

    /** @test */
    public function groupUpdated_event_can_be_created_and_data_retrieved(){
        $group = Group::factory()->create();
        $event = new GroupUpdated($group, ['updated' => 'data']);

        $this->assertTrue($group->is($event->group));
        $this->assertEquals(['updated' => 'data'], $event->updatedData);
    }

    /** @test */
    public function groupDeleted_event_can_be_created_and_data_retrieved(){
        $group = Group::factory()->create();
        $event = new GroupDeleted($group);

        $this->assertTrue($group->is($event->group));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getById(){
        $group = Group::factory()->create();

        $baseGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Group::class);
        $baseGroupRepo->getById(1)->shouldBeCalled()->willReturn($group);

        $eventDispatcher = new GroupEventDispatcher($baseGroupRepo->reveal());
        $this->assertTrue($group->is($eventDispatcher->getById(1)));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getByDataProviderId(){
        $group = Group::factory()->create();

        $baseGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Group::class);
        $baseGroupRepo->getByDataProviderId(1)->shouldBeCalled()->willReturn($group);

        $eventDispatcher = new GroupEventDispatcher($baseGroupRepo->reveal());
        $this->assertTrue($group->is($eventDispatcher->getByDataProviderId(1)));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_all(){
        $groups = Group::factory()->count(10)->create();

        $baseGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Group::class);
        $baseGroupRepo->all()->shouldBeCalled()->willReturn($groups);

        $eventDispatcher = new GroupEventDispatcher($baseGroupRepo->reveal());
        $allGroups = $eventDispatcher->all();
        $this->assertCount(10, $allGroups);
        foreach($allGroups as $group) {
            $this->assertTrue($groups->shift()->is($group));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_paginate(){
        $groups = Group::factory()->count(10)->create();

        $baseGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Group::class);
        $baseGroupRepo->paginate(1, 10)->shouldBeCalled()->willReturn($groups);

        $eventDispatcher = new GroupEventDispatcher($baseGroupRepo->reveal());
        $allGroups = $eventDispatcher->paginate(1, 10);
        $this->assertCount(10, $allGroups);
        foreach($allGroups as $group) {
            $this->assertTrue($groups->shift()->is($group));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_count(){
        $baseGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Group::class);
        $baseGroupRepo->count()->shouldBeCalled()->willReturn(5);

        $eventDispatcher = new GroupEventDispatcher($baseGroupRepo->reveal());
        $this->assertEquals(5, $eventDispatcher->count());
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_create_and_it_dispatches_an_event(){
        $group = Group::factory()->create();

        $baseGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Group::class);
        $baseGroupRepo->create(2)->shouldBeCalled()->willReturn($group);

        $eventDispatcher = new GroupEventDispatcher($baseGroupRepo->reveal());
        $newGroup = $eventDispatcher->create(2);
        $this->assertTrue($group->is($newGroup));

        Event::assertDispatched(
            GroupCreated::class,
            fn(GroupCreated $event) => $event->group->is($group)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_update_and_it_dispatches_an_event(){
        $group = Group::factory()->create(['data_provider_id' => 5]);

        $baseGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Group::class);
        $baseGroupRepo->getById($group->id())->willReturn($group);
        $baseGroupRepo->update($group->id(), 3)->shouldBeCalled()->willReturn($group);

        $eventDispatcher = new GroupEventDispatcher($baseGroupRepo->reveal());
        $newGroup = $eventDispatcher->update($group->id(), 3);
        $this->assertTrue($group->is($newGroup));

        Event::assertDispatched(
            GroupUpdated::class,
            fn(GroupUpdated $event) => $event->group->is($group) && $event->updatedData === ['data_provider_id' => 3]
        );
    }

    /** @test */
    public function for_update_updated_data_only_contains_updated_data(){
        $group = Group::factory()->create(['data_provider_id' => 5]);

        $baseGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Group::class);
        $baseGroupRepo->getById($group->id())->willReturn($group);
        $baseGroupRepo->update($group->id(), 5)->shouldBeCalled()->willReturn($group);

        $eventDispatcher = new GroupEventDispatcher($baseGroupRepo->reveal());
        $newGroup = $eventDispatcher->update($group->id(), 5);
        $this->assertTrue($group->is($newGroup));

        Event::assertDispatched(
            GroupUpdated::class,
            fn(GroupUpdated $event) => $event->group->is($group) && $event->updatedData === []
        );
    }

}
