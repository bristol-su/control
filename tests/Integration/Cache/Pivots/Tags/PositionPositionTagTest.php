<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Prophecy\Argument;

class PositionPositionTagTest extends TestCase
{
    /** @test */
    public function addTagToPosition_does_not_save_in_cache()
    {
        $positionTag = PositionTag::factory()->create();
        $position = Position::factory()->create();

        $positionPositionTagRepository = $this->prophesize(PositionPositionTag::class);
        $positionPositionTagRepository->addTagToPosition(Argument::that(function ($arg) use ($positionTag) {
            return $arg instanceof PositionTag && $arg->is($positionTag);
        }), Argument::that(function ($arg) use ($position) {
            return $arg instanceof Position && $arg->is($position);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionPositionTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\PositionPositionTag($positionPositionTagRepository->reveal(), $cache->reveal());

        $positionPositionTagCache->addTagToPosition($positionTag, $position);
    }

    /** @test */
    public function removeTagFromPosition_does_not_save_in_cache()
    {
        $positionTag = PositionTag::factory()->create();
        $position = Position::factory()->create();

        $positionPositionTagRepository = $this->prophesize(PositionPositionTag::class);
        $positionPositionTagRepository->removeTagFromPosition(Argument::that(function ($arg) use ($positionTag) {
            return $arg instanceof PositionTag && $arg->is($positionTag);
        }), Argument::that(function ($arg) use ($position) {
            return $arg instanceof Position && $arg->is($position);
        }))->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionPositionTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\PositionPositionTag($positionPositionTagRepository->reveal(), $cache->reveal());

        $positionPositionTagCache->removeTagFromPosition($positionTag, $position);
    }

    /** @test */
    public function getTagsThroughPosition_saves_the_tags_in_the_cache()
    {
        $positionTags = PositionTag::factory()->count(5)->create();
        $position = Position::factory()->create();

        $basePositionPositionTagRepository = $this->prophesize(PositionPositionTag::class);
        $basePositionPositionTagRepository->getTagsThroughPosition(Argument::that(function ($arg) use ($position) {
            return $arg instanceof Position && $arg->is($position);
        }))->shouldBeCalledTimes(1)->willReturn($positionTags);

        $positionPositionTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\PositionPositionTag($basePositionPositionTagRepository->reveal(), app(Repository::class));

        $assertPositionTags = function($positionTags) {
            $this->assertInstanceOf(Collection::class, $positionTags);
            $this->assertContainsOnlyInstancesOf(PositionTag::class, $positionTags);
            $this->assertCount(5, $positionTags);
        };

        // The underlying instance should only be called once
        $assertPositionTags($positionPositionTagCache->getTagsThroughPosition($position));
        $assertPositionTags($positionPositionTagCache->getTagsThroughPosition($position));
    }

    /** @test */
    public function getPositionsThroughTag_saves_the_positions_in_the_cache()
    {
        $positions = Position::factory()->count(5)->create();
        $positionTag = PositionTag::factory()->create();

        $basePositionPositionTagRepository = $this->prophesize(PositionPositionTag::class);
        $basePositionPositionTagRepository->getPositionsThroughTag(Argument::that(function ($arg) use ($positionTag) {
            return $arg instanceof PositionTag && $arg->is($positionTag);
        }))->shouldBeCalledTimes(1)->willReturn($positions);

        $positionPositionTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\PositionPositionTag($basePositionPositionTagRepository->reveal(), app(Repository::class));

        $assertPositions = function($positions) {
            $this->assertInstanceOf(Collection::class, $positions);
            $this->assertContainsOnlyInstancesOf(Position::class, $positions);
            $this->assertCount(5, $positions);
        };

        // The underlying instance should only be called once
        $assertPositions($positionPositionTagCache->getPositionsThroughTag($positionTag));
        $assertPositions($positionPositionTagCache->getPositionsThroughTag($positionTag));

    }
}
