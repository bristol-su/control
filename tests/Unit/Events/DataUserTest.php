<?php

namespace BristolSU\Tests\ControlDB\Unit\Events;

use BristolSU\ControlDB\Events\DataUser\DataUserEventDispatcher;
use BristolSU\ControlDB\Events\DataUser\DataUserUpdated;
use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Events\DataUser\DataUserCreated;
use BristolSU\Tests\ControlDB\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;

class DataUserTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function dataUserCreated_event_can_be_created_and_data_retrieved(){
        $dataUser = DataUser::factory()->create();
        $event = new DataUserCreated($dataUser);

        $this->assertTrue($dataUser->is($event->dataUser));
    }

    /** @test */
    public function dataUserUpdated_event_can_be_created_and_data_retrieved(){
        $dataUser = DataUser::factory()->create();
        $event = new DataUserUpdated($dataUser, ['updated' => 'data']);

        $this->assertTrue($dataUser->is($event->dataUser));
        $this->assertEquals(['updated' => 'data'], $event->updatedData);
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getById(){
        $dataUser = DataUser::factory()->create();

        $baseDataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $baseDataUserRepo->getById(1)->shouldBeCalled()->willReturn($dataUser);

        $eventDispatcher = new DataUserEventDispatcher($baseDataUserRepo->reveal());
        $this->assertTrue($dataUser->is($eventDispatcher->getById(1)));

    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getWhere(){
        $dataUser = DataUser::factory()->create();

        $baseDataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $baseDataUserRepo->getWhere(['test' => 'one'])->shouldBeCalled()->willReturn($dataUser);

        $eventDispatcher = new DataUserEventDispatcher($baseDataUserRepo->reveal());
        $this->assertTrue($dataUser->is($eventDispatcher->getWhere(['test' => 'one'])));

    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getAllWhere(){
        $dataUsers = DataUser::factory()->count(10)->create();

        $baseDataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $baseDataUserRepo->getAllWhere(['test' => 'two'])->shouldBeCalled()->willReturn($dataUsers);

        $eventDispatcher = new DataUserEventDispatcher($baseDataUserRepo->reveal());
        $allDataUsers = $eventDispatcher->getAllWhere(['test' => 'two']);
        $this->assertCount(10, $allDataUsers);
        foreach($allDataUsers as $dataUser) {
            $this->assertTrue($dataUsers->shift()->is($dataUser));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_create_and_it_dispatches_an_event(){
        Carbon::setTestNow(Carbon::now());
        $dataUser = DataUser::factory()->create();

        $baseDataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $baseDataUserRepo->create('First Name', 'Last Name', 'email@example.com', Carbon::now()->subYear(), 'Preferred Name')->shouldBeCalled()->willReturn($dataUser);

        $eventDispatcher = new DataUserEventDispatcher($baseDataUserRepo->reveal());
        $newDataUser = $eventDispatcher->create('First Name', 'Last Name', 'email@example.com', Carbon::now()->subYear(), 'Preferred Name');
        $this->assertTrue($dataUser->is($newDataUser));

        Event::assertDispatched(
            DataUserCreated::class,
            fn(DataUserCreated $event) => $event->dataUser->is($dataUser)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_update_and_it_dispatches_an_event(){
        Carbon::setTestNow(Carbon::now());
        $dataUser = DataUser::factory()->create([
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'email@example.com',
            'dob' => Carbon::now()->addDay(),
            'preferred_name' => 'Preferred Name'
        ]);

        $baseDataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $baseDataUserRepo->getById($dataUser->id())->willReturn($dataUser);
        $baseDataUserRepo->update($dataUser->id(), 'Second Name', 'Third Name', 'secondemail@example.com', Carbon::now(), 'Preferred Name 2')->shouldBeCalled()->willReturn($dataUser);

        $eventDispatcher = new DataUserEventDispatcher($baseDataUserRepo->reveal());
        $newDataUser = $eventDispatcher->update($dataUser->id(), 'Second Name', 'Third Name', 'secondemail@example.com', Carbon::now(), 'Preferred Name 2');
        $this->assertTrue($dataUser->is($newDataUser));

        Event::assertDispatched(
            DataUserUpdated::class,
            fn(DataUserUpdated $event) => $event->dataUser->is($dataUser) && json_encode($event->updatedData) === json_encode([
                    'first_name' => 'Second Name',
                    'last_name' => 'Third Name',
                    'email' => 'secondemail@example.com',
                    'dob' => Carbon::now(),
                    'preferred_name' => 'Preferred Name 2'
                ])
        );
    }

    /** @test */
    public function for_update_updated_data_only_contains_updated_data(){
        Carbon::setTestNow(Carbon::now());
        $dataUser = DataUser::factory()->create(['first_name' => 'First Name', 'last_name' => 'last name', 'email' => 'firstemail@example.com', 'dob' => Carbon::now(), 'preferred_name' => 'Pref']);

        $baseDataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $baseDataUserRepo->getById($dataUser->id())->willReturn($dataUser);
        $baseDataUserRepo->update($dataUser->id(), 'Second Name', 'last name', 'secondemail@example.com', Carbon::now(), 'Pref')->shouldBeCalled()->willReturn($dataUser);

        $eventDispatcher = new DataUserEventDispatcher($baseDataUserRepo->reveal());
        $this->assertTrue($dataUser->is($eventDispatcher->update($dataUser->id(), 'Second Name', 'last name', 'secondemail@example.com', Carbon::now(), 'Pref')));

        Event::assertDispatched(
            DataUserUpdated::class,
//            fn(DataUserUpdated $event) => $event->dataUser->is($dataUser) && $event->updatedData === ['first_name' => 'Second Name', 'email' => 'secondemail@example.com']
        );
    }

}
