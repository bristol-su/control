<?php

namespace BristolSU\Tests\ControlDB\Unit\Events;

use BristolSU\ControlDB\Events\DataGroup\DataGroupEventDispatcher;
use BristolSU\ControlDB\Events\DataGroup\DataGroupUpdated;
use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Events\DataGroup\DataGroupCreated;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;

class DataGroupTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function dataGroupCreated_event_can_be_created_and_data_retrieved(){
        $dataGroup = DataGroup::factory()->create();
        $event = new DataGroupCreated($dataGroup);

        $this->assertTrue($dataGroup->is($event->dataGroup));
    }

    /** @test */
    public function dataGroupUpdated_event_can_be_created_and_data_retrieved(){
        $dataGroup = DataGroup::factory()->create();
        $event = new DataGroupUpdated($dataGroup, ['updated' => 'data']);

        $this->assertTrue($dataGroup->is($event->dataGroup));
        $this->assertEquals(['updated' => 'data'], $event->updatedData);
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getById(){
        $dataGroup = DataGroup::factory()->create();

        $baseDataGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class);
        $baseDataGroupRepo->getById(1)->shouldBeCalled()->willReturn($dataGroup);

        $eventDispatcher = new DataGroupEventDispatcher($baseDataGroupRepo->reveal());
        $this->assertTrue($dataGroup->is($eventDispatcher->getById(1)));

    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getWhere(){
        $dataGroup = DataGroup::factory()->create();

        $baseDataGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class);
        $baseDataGroupRepo->getWhere(['test' => 'one'])->shouldBeCalled()->willReturn($dataGroup);

        $eventDispatcher = new DataGroupEventDispatcher($baseDataGroupRepo->reveal());
        $this->assertTrue($dataGroup->is($eventDispatcher->getWhere(['test' => 'one'])));

    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getAllWhere(){
        $dataGroups = DataGroup::factory()->count(10)->create();

        $baseDataGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class);
        $baseDataGroupRepo->getAllWhere(['test' => 'two'])->shouldBeCalled()->willReturn($dataGroups);

        $eventDispatcher = new DataGroupEventDispatcher($baseDataGroupRepo->reveal());
        $allDataGroups = $eventDispatcher->getAllWhere(['test' => 'two']);
        $this->assertCount(10, $allDataGroups);
        foreach($allDataGroups as $dataGroup) {
            $this->assertTrue($dataGroups->shift()->is($dataGroup));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_create_and_it_dispatches_an_event(){
        $dataGroup = DataGroup::factory()->create();

        $baseDataGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class);
        $baseDataGroupRepo->create('name', 'email@example.com')->shouldBeCalled()->willReturn($dataGroup);

        $eventDispatcher = new DataGroupEventDispatcher($baseDataGroupRepo->reveal());
        $newDataGroup = $eventDispatcher->create('name', 'email@example.com');
        $this->assertTrue($dataGroup->is($newDataGroup));

        Event::assertDispatched(
            DataGroupCreated::class,
            fn(DataGroupCreated $event) => $event->dataGroup->is($dataGroup)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_update_and_it_dispatches_an_event(){
        $dataGroup = DataGroup::factory()->create(['name' => 'First Name', 'email' => 'firstemail@example.com']);

        $baseDataGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class);
        $baseDataGroupRepo->getById($dataGroup->id())->willReturn($dataGroup);
        $baseDataGroupRepo->update($dataGroup->id(), 'Second Name', 'secondemail@example.com')->shouldBeCalled()->willReturn($dataGroup);

        $eventDispatcher = new DataGroupEventDispatcher($baseDataGroupRepo->reveal());
        $newDataGroup = $eventDispatcher->update($dataGroup->id(), 'Second Name', 'secondemail@example.com');
        $this->assertTrue($dataGroup->is($newDataGroup));

        Event::assertDispatched(
            DataGroupUpdated::class,
            fn(DataGroupUpdated $event) => $event->dataGroup->is($dataGroup) && $event->updatedData === ['name' => 'Second Name', 'email' => 'secondemail@example.com']
        );
    }

    /** @test */
    public function for_update_updated_data_only_contains_updated_data(){
        $dataGroup = DataGroup::factory()->create(['name' => 'First Name', 'email' => 'firstemail@example.com']);

        $baseDataGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class);
        $baseDataGroupRepo->getById($dataGroup->id())->willReturn($dataGroup);
        $baseDataGroupRepo->update($dataGroup->id(), 'Second Name', 'firstemail@example.com')->shouldBeCalled()->willReturn($dataGroup);

        $eventDispatcher = new DataGroupEventDispatcher($baseDataGroupRepo->reveal());
        $this->assertTrue($dataGroup->is($eventDispatcher->update($dataGroup->id(), 'Second Name', 'firstemail@example.com')));

        Event::assertDispatched(
            DataGroupUpdated::class,
            fn(DataGroupUpdated $event) => $event->dataGroup->is($dataGroup) && $event->updatedData === ['name' => 'Second Name']
        );
    }

}
