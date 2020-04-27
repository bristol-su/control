<?php

namespace BristolSU\ControlDB\Cache\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag as PositionPositionTagRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class PositionPositionTag implements PositionPositionTagRepository
{
    /**
     * @var PositionPositionTagRepository
     */
    private $positionPositionTagRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(PositionPositionTagRepository $positionPositionTagRepository, Repository $cache)
    {
        $this->positionPositionTagRepository = $positionPositionTagRepository;
        $this->cache = $cache;
    }

    /**
     * Tag a position
     *
     * @param PositionTag $positionTag Tag to tag the position with
     * @param Position $position Position to tag
     * @return void
     */
    public function addTagToPosition(PositionTag $positionTag, Position $position): void
    {
        $this->positionPositionTagRepository->addTagToPosition($positionTag, $position);
    }

    /**
     * Remove a tag from a position
     *
     * @param PositionTag $positionTag Tag to remove from the position
     * @param Position $position Position to remove the tag from
     * @return void
     */
    public function removeTagFromPosition(PositionTag $positionTag, Position $position): void
    {
        $this->positionPositionTagRepository->removeTagFromPosition($positionTag, $position);
    }

    /**
     * Get all tags a position is tagged with
     *
     * @param Position $position Position to retrieve tags from
     * @return Collection|PositionTag[] Tags the position is tagged with
     */
    public function getTagsThroughPosition(Position $position): Collection
    {
        return $this->cache->rememberForever(static::class . '@getTagsThroughPosition:' . $position->id(), function() use ($position) {
            return $this->positionPositionTagRepository->getTagsThroughPosition($position);
        });
    }

    /**
     * Get all positions tagged with a tag
     *
     * @param PositionTag $positionTag Tag to use to retrieve positions
     * @return Collection|Position[] Positions tagged with the given tag
     */
    public function getPositionsThroughTag(PositionTag $positionTag): Collection
    {
        return $this->cache->rememberForever(static::class . '@getPositionsThroughTag:' . $positionTag->id(), function() use ($positionTag) {
            return $this->positionPositionTagRepository->getPositionsThroughTag($positionTag);
        });   
    }
}