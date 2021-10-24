<?php

namespace BristolSU\Tests\ControlDB\Unit\Events\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Events\Pivots\Tags\GroupGroupTag\GroupGroupTagEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\Tags\GroupGroupTag\GroupTagged;
use BristolSU\ControlDB\Events\Pivots\Tags\GroupGroupTag\GroupUntagged;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;
use Prophecy\Argument;

class GroupGroupTagTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function groupTagged_event_can_be_created_and_data_retrieved(){
        $group = Group::factory()->create();
        $groupTag = GroupTag::factory()->create();

        $event = new GroupTagged($group, $groupTag);

        $this->assertTrue($group->is($event->group));
        $this->assertTrue($groupTag->is($event->groupTag));
    }

    /** @test */
    public function groupUntagged_event_can_be_created_and_data_retrieved(){
        $group = Group::factory()->create();
        $groupTag = GroupTag::factory()->create();

        $event = new GroupUntagged($group, $groupTag);

        $this->assertTrue($group->is($event->group));
        $this->assertTrue($groupTag->is($event->groupTag));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getTagsThroughGroup(){
        $group = Group::factory()->create();
        $groupTags = GroupTag::factory()->count(10)->create();

        $baseGroupTagGroupRepo = $this->prophesize(GroupGroupTag::class);
        $baseGroupTagGroupRepo->getTagsThroughGroup(Argument::that(fn($arg) => $arg instanceof Group && $arg->is($group)))
            ->shouldBeCalled()->willReturn($groupTags);

        $eventDispatcher = new GroupGroupTagEventDispatcher($baseGroupTagGroupRepo->reveal());
        $allGroupTags = $eventDispatcher->getTagsThroughGroup($group);
        $this->assertCount(10, $allGroupTags);
        foreach($allGroupTags as $groupTag) {
            $this->assertTrue($groupTags->shift()->is($groupTag));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getGroupsThroughTag(){
        $groups = Group::factory()->count(10)->create();
        $groupTag = GroupTag::factory()->create();

        $baseGroupGroupTagRepo = $this->prophesize(GroupGroupTag::class);
        $baseGroupGroupTagRepo->getGroupsThroughTag(Argument::that(fn($arg) => $arg instanceof GroupTag && $arg->is($groupTag)))
            ->shouldBeCalled()->willReturn($groups);

        $eventDispatcher = new GroupGroupTagEventDispatcher($baseGroupGroupTagRepo->reveal());
        $allGroups = $eventDispatcher->getGroupsThroughTag($groupTag);
        $this->assertCount(10, $allGroups);
        foreach($allGroups as $group) {
            $this->assertTrue($groups->shift()->is($group));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_addTagToGroup_and_it_dispatches_an_event(){
        $group = Group::factory()->create();
        $groupTag = GroupTag::factory()->create();

        $baseGroupGroupTagRepo = $this->prophesize(GroupGroupTag::class);
        $baseGroupGroupTagRepo->addTagToGroup(
            Argument::that(fn($arg) => $arg instanceof GroupTag && $arg->is($groupTag)),
            Argument::that(fn($arg) => $arg instanceof Group && $arg->is($group))
        )->shouldBeCalled();

        $eventDispatcher = new GroupGroupTagEventDispatcher($baseGroupGroupTagRepo->reveal());
        $eventDispatcher->addTagToGroup($groupTag, $group);

        Event::assertDispatched(
            GroupTagged::class,
            fn(GroupTagged $event) => $groupTag->is($event->groupTag) && $group->is($event->group)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_removeTagFromGroup_and_it_dispatches_an_event(){
        $group = Group::factory()->create();
        $groupTag = GroupTag::factory()->create();

        $baseGroupGroupTagRepo = $this->prophesize(GroupGroupTag::class);
        $baseGroupGroupTagRepo->removeTagFromGroup(
            Argument::that(fn($arg) => $arg instanceof GroupTag && $arg->is($groupTag)),
            Argument::that(fn($arg) => $arg instanceof Group && $arg->is($group))
        )->shouldBeCalled();

        $eventDispatcher = new GroupGroupTagEventDispatcher($baseGroupGroupTagRepo->reveal());
        $eventDispatcher->removeTagFromGroup($groupTag, $group);

        Event::assertDispatched(
            GroupUntagged::class,
            fn(GroupUntagged $event) => $groupTag->is($event->groupTag) && $group->is($event->group)
        );
    }

}
