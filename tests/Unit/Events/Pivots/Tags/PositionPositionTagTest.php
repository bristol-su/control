<?php

namespace BristolSU\Tests\ControlDB\Unit\Events\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Events\Pivots\Tags\PositionPositionTag\PositionPositionTagEventDispatcher;
use BristolSU\ControlDB\Events\Pivots\Tags\PositionPositionTag\PositionTagged;
use BristolSU\ControlDB\Events\Pivots\Tags\PositionPositionTag\PositionUntagged;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Event;
use Prophecy\Argument;

class PositionPositionTagTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
    }

    /** @test */
    public function positionTagged_event_can_be_created_and_data_retrieved(){
        $position = Position::factory()->create();
        $positionTag = PositionTag::factory()->create();

        $event = new PositionTagged($position, $positionTag);

        $this->assertTrue($position->is($event->position));
        $this->assertTrue($positionTag->is($event->positionTag));
    }

    /** @test */
    public function positionUntagged_event_can_be_created_and_data_retrieved(){
        $position = Position::factory()->create();
        $positionTag = PositionTag::factory()->create();

        $event = new PositionUntagged($position, $positionTag);

        $this->assertTrue($position->is($event->position));
        $this->assertTrue($positionTag->is($event->positionTag));
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getTagsThroughPosition(){
        $position = Position::factory()->create();
        $positionTags = PositionTag::factory()->count(10)->create();

        $basePositionTagPositionRepo = $this->prophesize(PositionPositionTag::class);
        $basePositionTagPositionRepo->getTagsThroughPosition(Argument::that(fn($arg) => $arg instanceof Position && $arg->is($position)))
            ->shouldBeCalled()->willReturn($positionTags);

        $eventDispatcher = new PositionPositionTagEventDispatcher($basePositionTagPositionRepo->reveal());
        $allPositionTags = $eventDispatcher->getTagsThroughPosition($position);
        $this->assertCount(10, $allPositionTags);
        foreach($allPositionTags as $positionTag) {
            $this->assertTrue($positionTags->shift()->is($positionTag));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_getPositionsThroughTag(){
        $positions = Position::factory()->count(10)->create();
        $positionTag = PositionTag::factory()->create();

        $basePositionPositionTagRepo = $this->prophesize(PositionPositionTag::class);
        $basePositionPositionTagRepo->getPositionsThroughTag(Argument::that(fn($arg) => $arg instanceof PositionTag && $arg->is($positionTag)))
            ->shouldBeCalled()->willReturn($positions);

        $eventDispatcher = new PositionPositionTagEventDispatcher($basePositionPositionTagRepo->reveal());
        $allPositions = $eventDispatcher->getPositionsThroughTag($positionTag);
        $this->assertCount(10, $allPositions);
        foreach($allPositions as $position) {
            $this->assertTrue($positions->shift()->is($position));
        }
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_addTagToPosition_and_it_dispatches_an_event(){
        $position = Position::factory()->create();
        $positionTag = PositionTag::factory()->create();

        $basePositionPositionTagRepo = $this->prophesize(PositionPositionTag::class);
        $basePositionPositionTagRepo->addTagToPosition(
            Argument::that(fn($arg) => $arg instanceof PositionTag && $arg->is($positionTag)),
            Argument::that(fn($arg) => $arg instanceof Position && $arg->is($position))
        )->shouldBeCalled();

        $eventDispatcher = new PositionPositionTagEventDispatcher($basePositionPositionTagRepo->reveal());
        $eventDispatcher->addTagToPosition($positionTag, $position);

        Event::assertDispatched(
            PositionTagged::class,
            fn(PositionTagged $event) => $positionTag->is($event->positionTag) && $position->is($event->position)
        );
    }

    /** @test */
    public function it_calls_and_returns_the_underlying_instance_for_removeTagFromPosition_and_it_dispatches_an_event(){
        $position = Position::factory()->create();
        $positionTag = PositionTag::factory()->create();

        $basePositionPositionTagRepo = $this->prophesize(PositionPositionTag::class);
        $basePositionPositionTagRepo->removeTagFromPosition(
            Argument::that(fn($arg) => $arg instanceof PositionTag && $arg->is($positionTag)),
            Argument::that(fn($arg) => $arg instanceof Position && $arg->is($position))
        )->shouldBeCalled();

        $eventDispatcher = new PositionPositionTagEventDispatcher($basePositionPositionTagRepo->reveal());
        $eventDispatcher->removeTagFromPosition($positionTag, $position);

        Event::assertDispatched(
            PositionUntagged::class,
            fn(PositionUntagged $event) => $positionTag->is($event->positionTag) && $position->is($event->position)
        );
    }

}
