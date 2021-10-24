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
        $key = static::class . '@getTagsThroughPosition:' . $position->id();
        if(!$this->cache->has($key)) {
            $positionTags = $this->positionPositionTagRepository->getTagsThroughPosition($position);
            $this->cache->forever($key, $positionTags->map(fn(PositionTag $positionTag) => $positionTag->id())->all());
            return $positionTags;
        }
        return collect($this->cache->get($key))
            ->map(fn(int $positionTagId) => app(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag::class)->getById($positionTagId));
    }

    /**
     * Get all positions tagged with a tag
     *
     * @param PositionTag $positionTag Tag to use to retrieve positions
     * @return Collection|Position[] Positions tagged with the given tag
     */
    public function getPositionsThroughTag(PositionTag $positionTag): Collection
    {
        $key = static::class . '@getPositionsThroughTag:' . $positionTag->id();
        if(!$this->cache->has($key)) {
            $positions = $this->positionPositionTagRepository->getPositionsThroughTag($positionTag);
            $this->cache->forever($key, $positions->map(fn(Position $position) => $position->id())->all());
            return $positions;
        }
        return collect($this->cache->get($key))
            ->map(fn(int $positionId) => app(\BristolSU\ControlDB\Contracts\Repositories\Position::class)->getById($positionId));
    }
}
