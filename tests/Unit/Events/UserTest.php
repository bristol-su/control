<?php

namespace BristolSU\Tests\ControlDB\Unit\Events;

use BristolSU\ControlDB\Events\User\UserDeleted;
use BristolSU\ControlDB\Events\User\UserEventDispatcher;
use BristolSU\ControlDB\Events\User\UserUpdated;
use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Events\User\UserCreated;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;

class UserTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function userCreated_event_can_be_created_and_data_retrieved(){
        $user = User::factory()->create();
        $event = new UserCreated($user);

        $this->assertTrue($user->is($event->user));
    }

    /** @test */
    public function userUpdated_event_can_be_created_and_data_retrieved(){
        $user = User::factory()->create();
        $event = new UserUpdated($user, ['updated' => 'data']);

        $this->assertTrue($user->is($event->user));
        $this->assertEquals(['updated' => 'data'], $event->updatedData);
    }

    /** @test */
    public function userDeleted_event_can_be_created_and_data_retrieved(){
        $user = User::factory()->create();
        $event = new UserDeleted($user);

        $this->assertTrue($user->is($event->user));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getById(){
        $user = User::factory()->create();

        $baseUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\User::class);
        $baseUserRepo->getById(1)->shouldBeCalled()->willReturn($user);

        $eventDispatcher = new UserEventDispatcher($baseUserRepo->reveal());
        $this->assertTrue($user->is($eventDispatcher->getById(1)));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getByDataProviderId(){
        $user = User::factory()->create();

        $baseUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\User::class);
        $baseUserRepo->getByDataProviderId(1)->shouldBeCalled()->willReturn($user);

        $eventDispatcher = new UserEventDispatcher($baseUserRepo->reveal());
        $this->assertTrue($user->is($eventDispatcher->getByDataProviderId(1)));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_all(){
        $users = User::factory()->count(10)->create();

        $baseUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\User::class);
        $baseUserRepo->all()->shouldBeCalled()->willReturn($users);

        $eventDispatcher = new UserEventDispatcher($baseUserRepo->reveal());
        $allUsers = $eventDispatcher->all();
        $this->assertCount(10, $allUsers);
        foreach($allUsers as $user) {
            $this->assertTrue($users->shift()->is($user));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_paginate(){
        $users = User::factory()->count(10)->create();

        $baseUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\User::class);
        $baseUserRepo->paginate(1, 10)->shouldBeCalled()->willReturn($users);

        $eventDispatcher = new UserEventDispatcher($baseUserRepo->reveal());
        $allUsers = $eventDispatcher->paginate(1, 10);
        $this->assertCount(10, $allUsers);
        foreach($allUsers as $user) {
            $this->assertTrue($users->shift()->is($user));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_count(){
        $baseUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\User::class);
        $baseUserRepo->count()->shouldBeCalled()->willReturn(5);

        $eventDispatcher = new UserEventDispatcher($baseUserRepo->reveal());
        $this->assertEquals(5, $eventDispatcher->count());
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_create_and_it_dispatches_an_event(){
        $user = User::factory()->create();

        $baseUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\User::class);
        $baseUserRepo->create(2)->shouldBeCalled()->willReturn($user);

        $eventDispatcher = new UserEventDispatcher($baseUserRepo->reveal());
        $newUser = $eventDispatcher->create(2);
        $this->assertTrue($user->is($newUser));

        Event::assertDispatched(
            UserCreated::class,
            fn(UserCreated $event) => $event->user->is($user)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_update_and_it_dispatches_an_event(){
        $user = User::factory()->create(['data_provider_id' => 5]);

        $baseUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\User::class);
        $baseUserRepo->getById($user->id())->willReturn($user);
        $baseUserRepo->update($user->id(), 3)->shouldBeCalled()->willReturn($user);

        $eventDispatcher = new UserEventDispatcher($baseUserRepo->reveal());
        $newUser = $eventDispatcher->update($user->id(), 3);
        $this->assertTrue($user->is($newUser));

        Event::assertDispatched(
            UserUpdated::class,
            fn(UserUpdated $event) => $event->user->is($user) && $event->updatedData === ['data_provider_id' => 3]
        );
    }

    /** @test */
    public function for_update_updated_data_only_contains_updated_data(){
        $user = User::factory()->create(['data_provider_id' => 5]);

        $baseUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\User::class);
        $baseUserRepo->getById($user->id())->willReturn($user);
        $baseUserRepo->update($user->id(), 5)->shouldBeCalled()->willReturn($user);

        $eventDispatcher = new UserEventDispatcher($baseUserRepo->reveal());
        $newUser = $eventDispatcher->update($user->id(), 5);
        $this->assertTrue($user->is($newUser));

        Event::assertDispatched(
            UserUpdated::class,
            fn(UserUpdated $event) => $event->user->is($user) && $event->updatedData === []
        );
    }

}
