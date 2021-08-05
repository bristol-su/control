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

        $positionPositionTagRepository = $this->prophesize(PositionPositionTag::class);
        $positionPositionTagRepository->getTagsThroughPosition(Argument::that(function ($arg) use ($position) {
            return $arg instanceof Position && $arg->is($position);
        }))->shouldBeCalled()->willReturn($positionTags);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\Tags\PositionPositionTag::class . '@getTagsThroughPosition:' . $position->id();

        $positionPositionTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\PositionPositionTag($positionPositionTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $positionPositionTagCache->getTagsThroughPosition($position));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(PositionTag::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }

    /** @test */
    public function getPositionsThroughTag_saves_the_positions_in_the_cache()
    {
        $positions = Position::factory()->count(5)->create();
        $positionTag = PositionTag::factory()->create();

        $positionPositionTagRepository = $this->prophesize(PositionPositionTag::class);
        $positionPositionTagRepository->getPositionsThroughTag(Argument::that(function ($arg) use ($positionTag) {
            return $arg instanceof PositionTag && $arg->is($positionTag);
        }))->shouldBeCalled()->willReturn($positions);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Pivots\Tags\PositionPositionTag::class . '@getPositionsThroughTag:' . $positionTag->id();

        $positionTagTagCache = new \BristolSU\ControlDB\Cache\Pivots\Tags\PositionPositionTag($positionPositionTagRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $positionTagTagCache->getPositionsThroughTag($positionTag));
        $this->assertTrue($cache->has($key));
        $this->assertInstanceOf(Collection::class, $cache->get($key));
        $this->assertContainsOnlyInstancesOf(Position::class, $cache->get($key));
        $this->assertCount(5, $cache->get($key));
    }
}
