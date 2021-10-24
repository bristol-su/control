<?php

namespace BristolSU\Tests\ControlDB\Unit\Events;

use BristolSU\ControlDB\Events\Position\PositionDeleted;
use BristolSU\ControlDB\Events\Position\PositionEventDispatcher;
use BristolSU\ControlDB\Events\Position\PositionUpdated;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Events\Position\PositionCreated;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;

class PositionTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function positionCreated_event_can_be_created_and_data_retrieved(){
        $position = Position::factory()->create();
        $event = new PositionCreated($position);

        $this->assertTrue($position->is($event->position));
    }

    /** @test */
    public function positionUpdated_event_can_be_created_and_data_retrieved(){
        $position = Position::factory()->create();
        $event = new PositionUpdated($position, ['updated' => 'data']);

        $this->assertTrue($position->is($event->position));
        $this->assertEquals(['updated' => 'data'], $event->updatedData);
    }

    /** @test */
    public function positionDeleted_event_can_be_created_and_data_retrieved(){
        $position = Position::factory()->create();
        $event = new PositionDeleted($position);

        $this->assertTrue($position->is($event->position));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getById(){
        $position = Position::factory()->create();

        $basePositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Position::class);
        $basePositionRepo->getById(1)->shouldBeCalled()->willReturn($position);

        $eventDispatcher = new PositionEventDispatcher($basePositionRepo->reveal());
        $this->assertTrue($position->is($eventDispatcher->getById(1)));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getByDataProviderId(){
        $position = Position::factory()->create();

        $basePositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Position::class);
        $basePositionRepo->getByDataProviderId(1)->shouldBeCalled()->willReturn($position);

        $eventDispatcher = new PositionEventDispatcher($basePositionRepo->reveal());
        $this->assertTrue($position->is($eventDispatcher->getByDataProviderId(1)));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_all(){
        $positions = Position::factory()->count(10)->create();

        $basePositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Position::class);
        $basePositionRepo->all()->shouldBeCalled()->willReturn($positions);

        $eventDispatcher = new PositionEventDispatcher($basePositionRepo->reveal());
        $allPositions = $eventDispatcher->all();
        $this->assertCount(10, $allPositions);
        foreach($allPositions as $position) {
            $this->assertTrue($positions->shift()->is($position));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_paginate(){
        $positions = Position::factory()->count(10)->create();

        $basePositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Position::class);
        $basePositionRepo->paginate(1, 10)->shouldBeCalled()->willReturn($positions);

        $eventDispatcher = new PositionEventDispatcher($basePositionRepo->reveal());
        $allPositions = $eventDispatcher->paginate(1, 10);
        $this->assertCount(10, $allPositions);
        foreach($allPositions as $position) {
            $this->assertTrue($positions->shift()->is($position));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_count(){
        $basePositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Position::class);
        $basePositionRepo->count()->shouldBeCalled()->willReturn(5);

        $eventDispatcher = new PositionEventDispatcher($basePositionRepo->reveal());
        $this->assertEquals(5, $eventDispatcher->count());
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_create_and_it_dispatches_an_event(){
        $position = Position::factory()->create();

        $basePositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Position::class);
        $basePositionRepo->create(2)->shouldBeCalled()->willReturn($position);

        $eventDispatcher = new PositionEventDispatcher($basePositionRepo->reveal());
        $newPosition = $eventDispatcher->create(2);
        $this->assertTrue($position->is($newPosition));

        Event::assertDispatched(
            PositionCreated::class,
            fn(PositionCreated $event) => $event->position->is($position)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_update_and_it_dispatches_an_event(){
        $position = Position::factory()->create(['data_provider_id' => 5]);

        $basePositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Position::class);
        $basePositionRepo->getById($position->id())->willReturn($position);
        $basePositionRepo->update($position->id(), 3)->shouldBeCalled()->willReturn($position);

        $eventDispatcher = new PositionEventDispatcher($basePositionRepo->reveal());
        $newPosition = $eventDispatcher->update($position->id(), 3);
        $this->assertTrue($position->is($newPosition));

        Event::assertDispatched(
            PositionUpdated::class,
            fn(PositionUpdated $event) => $event->position->is($position) && $event->updatedData === ['data_provider_id' => 3]
        );
    }

    /** @test */
    public function for_update_updated_data_only_contains_updated_data(){
        $position = Position::factory()->create(['data_provider_id' => 5]);

        $basePositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\Position::class);
        $basePositionRepo->getById($position->id())->willReturn($position);
        $basePositionRepo->update($position->id(), 5)->shouldBeCalled()->willReturn($position);

        $eventDispatcher = new PositionEventDispatcher($basePositionRepo->reveal());
        $newPosition = $eventDispatcher->update($position->id(), 5);
        $this->assertTrue($position->is($newPosition));

        Event::assertDispatched(
            PositionUpdated::class,
            fn(PositionUpdated $event) => $event->position->is($position) && $event->updatedData === []
        );
    }

}
