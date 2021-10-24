<?php

namespace BristolSU\Tests\ControlDB\Unit\Events;

use BristolSU\ControlDB\Events\DataRole\DataRoleEventDispatcher;
use BristolSU\ControlDB\Events\DataRole\DataRoleUpdated;
use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Events\DataRole\DataRoleCreated;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;

class DataRoleTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function dataRoleCreated_event_can_be_created_and_data_retrieved(){
        $dataRole = DataRole::factory()->create();
        $event = new DataRoleCreated($dataRole);

        $this->assertTrue($dataRole->is($event->dataRole));
    }

    /** @test */
    public function dataRoleUpdated_event_can_be_created_and_data_retrieved(){
        $dataRole = DataRole::factory()->create();
        $event = new DataRoleUpdated($dataRole, ['updated' => 'data']);

        $this->assertTrue($dataRole->is($event->dataRole));
        $this->assertEquals(['updated' => 'data'], $event->updatedData);
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getById(){
        $dataRole = DataRole::factory()->create();

        $baseDataRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class);
        $baseDataRoleRepo->getById(1)->shouldBeCalled()->willReturn($dataRole);

        $eventDispatcher = new DataRoleEventDispatcher($baseDataRoleRepo->reveal());
        $this->assertTrue($dataRole->is($eventDispatcher->getById(1)));

    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getWhere(){
        $dataRole = DataRole::factory()->create();

        $baseDataRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class);
        $baseDataRoleRepo->getWhere(['test' => 'one'])->shouldBeCalled()->willReturn($dataRole);

        $eventDispatcher = new DataRoleEventDispatcher($baseDataRoleRepo->reveal());
        $this->assertTrue($dataRole->is($eventDispatcher->getWhere(['test' => 'one'])));

    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getAllWhere(){
        $dataRoles = DataRole::factory()->count(10)->create();

        $baseDataRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class);
        $baseDataRoleRepo->getAllWhere(['test' => 'two'])->shouldBeCalled()->willReturn($dataRoles);

        $eventDispatcher = new DataRoleEventDispatcher($baseDataRoleRepo->reveal());
        $allDataRoles = $eventDispatcher->getAllWhere(['test' => 'two']);
        $this->assertCount(10, $allDataRoles);
        foreach($allDataRoles as $dataRole) {
            $this->assertTrue($dataRoles->shift()->is($dataRole));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_create_and_it_dispatches_an_event(){
        $dataRole = DataRole::factory()->create();

        $baseDataRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class);
        $baseDataRoleRepo->create('role_name', 'email@example.com')->shouldBeCalled()->willReturn($dataRole);

        $eventDispatcher = new DataRoleEventDispatcher($baseDataRoleRepo->reveal());
        $newDataRole = $eventDispatcher->create('role_name', 'email@example.com');
        $this->assertTrue($dataRole->is($newDataRole));

        Event::assertDispatched(
            DataRoleCreated::class,
            fn(DataRoleCreated $event) => $event->dataRole->is($dataRole)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_update_and_it_dispatches_an_event(){
        $dataRole = DataRole::factory()->create(['role_name' => 'First Name', 'email' => 'firstemail@example.com']);

        $baseDataRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class);
        $baseDataRoleRepo->getById($dataRole->id())->willReturn($dataRole);
        $baseDataRoleRepo->update($dataRole->id(), 'Second Name', 'secondemail@example.com')->shouldBeCalled()->willReturn($dataRole);

        $eventDispatcher = new DataRoleEventDispatcher($baseDataRoleRepo->reveal());
        $newDataRole = $eventDispatcher->update($dataRole->id(), 'Second Name', 'secondemail@example.com');
        $this->assertTrue($dataRole->is($newDataRole));

        Event::assertDispatched(
            DataRoleUpdated::class,
            fn(DataRoleUpdated $event) => $event->dataRole->is($dataRole) && $event->updatedData === ['role_name' => 'Second Name', 'email' => 'secondemail@example.com']
        );
    }

    /** @test */
    public function for_update_updated_data_only_contains_updated_data(){
        $dataRole = DataRole::factory()->create(['role_name' => 'First Name', 'email' => 'firstemail@example.com']);

        $baseDataRoleRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class);
        $baseDataRoleRepo->getById($dataRole->id())->willReturn($dataRole);
        $baseDataRoleRepo->update($dataRole->id(), 'Second Name', 'firstemail@example.com')->shouldBeCalled()->willReturn($dataRole);

        $eventDispatcher = new DataRoleEventDispatcher($baseDataRoleRepo->reveal());
        $this->assertTrue($dataRole->is($eventDispatcher->update($dataRole->id(), 'Second Name', 'firstemail@example.com')));

        Event::assertDispatched(
            DataRoleUpdated::class,
            fn(DataRoleUpdated $event) => $event->dataRole->is($dataRole) && $event->updatedData === ['role_name' => 'Second Name']
        );
    }

}
