<?php

namespace BristolSU\Tests\ControlDB\Unit\Events;

use BristolSU\ControlDB\Events\DataPosition\DataPositionEventDispatcher;
use BristolSU\ControlDB\Events\DataPosition\DataPositionUpdated;
use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Events\DataPosition\DataPositionCreated;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;

class DataPositionTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function dataPositionCreated_event_can_be_created_and_data_retrieved(){
        $dataPosition = DataPosition::factory()->create();
        $event = new DataPositionCreated($dataPosition);

        $this->assertTrue($dataPosition->is($event->dataPosition));
    }

    /** @test */
    public function dataPositionUpdated_event_can_be_created_and_data_retrieved(){
        $dataPosition = DataPosition::factory()->create();
        $event = new DataPositionUpdated($dataPosition, ['updated' => 'data']);

        $this->assertTrue($dataPosition->is($event->dataPosition));
        $this->assertEquals(['updated' => 'data'], $event->updatedData);
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getById(){
        $dataPosition = DataPosition::factory()->create();

        $baseDataPositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class);
        $baseDataPositionRepo->getById(1)->shouldBeCalled()->willReturn($dataPosition);

        $eventDispatcher = new DataPositionEventDispatcher($baseDataPositionRepo->reveal());
        $this->assertTrue($dataPosition->is($eventDispatcher->getById(1)));

    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getWhere(){
        $dataPosition = DataPosition::factory()->create();

        $baseDataPositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class);
        $baseDataPositionRepo->getWhere(['test' => 'one'])->shouldBeCalled()->willReturn($dataPosition);

        $eventDispatcher = new DataPositionEventDispatcher($baseDataPositionRepo->reveal());
        $this->assertTrue($dataPosition->is($eventDispatcher->getWhere(['test' => 'one'])));

    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getAllWhere(){
        $dataPositions = DataPosition::factory()->count(10)->create();

        $baseDataPositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class);
        $baseDataPositionRepo->getAllWhere(['test' => 'two'])->shouldBeCalled()->willReturn($dataPositions);

        $eventDispatcher = new DataPositionEventDispatcher($baseDataPositionRepo->reveal());
        $allDataPositions = $eventDispatcher->getAllWhere(['test' => 'two']);
        $this->assertCount(10, $allDataPositions);
        foreach($allDataPositions as $dataPosition) {
            $this->assertTrue($dataPositions->shift()->is($dataPosition));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_create_and_it_dispatches_an_event(){
        $dataPosition = DataPosition::factory()->create();

        $baseDataPositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class);
        $baseDataPositionRepo->create('name', 'description')->shouldBeCalled()->willReturn($dataPosition);

        $eventDispatcher = new DataPositionEventDispatcher($baseDataPositionRepo->reveal());
        $newDataPosition = $eventDispatcher->create('name', 'description');
        $this->assertTrue($dataPosition->is($newDataPosition));

        Event::assertDispatched(
            DataPositionCreated::class,
            fn(DataPositionCreated $event) => $event->dataPosition->is($dataPosition)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_update_and_it_dispatches_an_event(){
        $dataPosition = DataPosition::factory()->create(['name' => 'First Name', 'description' => 'firstdescription']);

        $baseDataPositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class);
        $baseDataPositionRepo->getById($dataPosition->id())->willReturn($dataPosition);
        $baseDataPositionRepo->update($dataPosition->id(), 'Second Name', 'seconddescription')->shouldBeCalled()->willReturn($dataPosition);

        $eventDispatcher = new DataPositionEventDispatcher($baseDataPositionRepo->reveal());
        $newDataPosition = $eventDispatcher->update($dataPosition->id(), 'Second Name', 'seconddescription');
        $this->assertTrue($dataPosition->is($newDataPosition));

        Event::assertDispatched(
            DataPositionUpdated::class,
            fn(DataPositionUpdated $event) => $event->dataPosition->is($dataPosition) && $event->updatedData === ['name' => 'Second Name', 'description' => 'seconddescription']
        );
    }

    /** @test */
    public function for_update_updated_data_only_contains_updated_data(){
        $dataPosition = DataPosition::factory()->create(['name' => 'First Name', 'description' => 'firstdescription']);

        $baseDataPositionRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class);
        $baseDataPositionRepo->getById($dataPosition->id())->willReturn($dataPosition);
        $baseDataPositionRepo->update($dataPosition->id(), 'Second Name', 'firstdescription')->shouldBeCalled()->willReturn($dataPosition);

        $eventDispatcher = new DataPositionEventDispatcher($baseDataPositionRepo->reveal());
        $this->assertTrue($dataPosition->is($eventDispatcher->update($dataPosition->id(), 'Second Name', 'firstdescription')));

        Event::assertDispatched(
            DataPositionUpdated::class,
            fn(DataPositionUpdated $event) => $event->dataPosition->is($dataPosition) && $event->updatedData === ['name' => 'Second Name']
        );
    }

}
