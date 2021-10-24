<?php

namespace BristolSU\Tests\ControlDB\Unit\Events\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Events\Pivots\Tags\UserUserTag\UserUserTagEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\Tags\UserUserTag\UserTagged;
use BristolSU\ControlDB\Events\Pivots\Tags\UserUserTag\UserUntagged;
use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;
use Prophecy\Argument;

class UserUserTagTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function userTagged_event_can_be_created_and_data_retrieved(){
        $user = User::factory()->create();
        $userTag = UserTag::factory()->create();

        $event = new UserTagged($user, $userTag);

        $this->assertTrue($user->is($event->user));
        $this->assertTrue($userTag->is($event->userTag));
    }

    /** @test */
    public function userUntagged_event_can_be_created_and_data_retrieved(){
        $user = User::factory()->create();
        $userTag = UserTag::factory()->create();

        $event = new UserUntagged($user, $userTag);

        $this->assertTrue($user->is($event->user));
        $this->assertTrue($userTag->is($event->userTag));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getTagsThroughUser(){
        $user = User::factory()->create();
        $userTags = UserTag::factory()->count(10)->create();

        $baseUserTagUserRepo = $this->prophesize(UserUserTag::class);
        $baseUserTagUserRepo->getTagsThroughUser(Argument::that(fn($arg) => $arg instanceof User && $arg->is($user)))
            ->shouldBeCalled()->willReturn($userTags);

        $eventDispatcher = new UserUserTagEventDispatcher($baseUserTagUserRepo->reveal());
        $allUserTags = $eventDispatcher->getTagsThroughUser($user);
        $this->assertCount(10, $allUserTags);
        foreach($allUserTags as $userTag) {
            $this->assertTrue($userTags->shift()->is($userTag));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getUsersThroughTag(){
        $users = User::factory()->count(10)->create();
        $userTag = UserTag::factory()->create();

        $baseUserUserTagRepo = $this->prophesize(UserUserTag::class);
        $baseUserUserTagRepo->getUsersThroughTag(Argument::that(fn($arg) => $arg instanceof UserTag && $arg->is($userTag)))
            ->shouldBeCalled()->willReturn($users);

        $eventDispatcher = new UserUserTagEventDispatcher($baseUserUserTagRepo->reveal());
        $allUsers = $eventDispatcher->getUsersThroughTag($userTag);
        $this->assertCount(10, $allUsers);
        foreach($allUsers as $user) {
            $this->assertTrue($users->shift()->is($user));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_addTagToUser_and_it_dispatches_an_event(){
        $user = User::factory()->create();
        $userTag = UserTag::factory()->create();

        $baseUserUserTagRepo = $this->prophesize(UserUserTag::class);
        $baseUserUserTagRepo->addTagToUser(
            Argument::that(fn($arg) => $arg instanceof UserTag && $arg->is($userTag)),
            Argument::that(fn($arg) => $arg instanceof User && $arg->is($user))
        )->shouldBeCalled();

        $eventDispatcher = new UserUserTagEventDispatcher($baseUserUserTagRepo->reveal());
        $eventDispatcher->addTagToUser($userTag, $user);

        Event::assertDispatched(
            UserTagged::class,
            fn(UserTagged $event) => $userTag->is($event->userTag) && $user->is($event->user)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_removeTagFromUser_and_it_dispatches_an_event(){
        $user = User::factory()->create();
        $userTag = UserTag::factory()->create();

        $baseUserUserTagRepo = $this->prophesize(UserUserTag::class);
        $baseUserUserTagRepo->removeTagFromUser(
            Argument::that(fn($arg) => $arg instanceof UserTag && $arg->is($userTag)),
            Argument::that(fn($arg) => $arg instanceof User && $arg->is($user))
        )->shouldBeCalled();

        $eventDispatcher = new UserUserTagEventDispatcher($baseUserUserTagRepo->reveal());
        $eventDispatcher->removeTagFromUser($userTag, $user);

        Event::assertDispatched(
            UserUntagged::class,
            fn(UserUntagged $event) => $userTag->is($event->userTag) && $user->is($event->user)
        );
    }

}
