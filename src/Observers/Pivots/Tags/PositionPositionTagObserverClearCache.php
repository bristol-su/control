<?php

namespace BristolSU\ControlDB\Observers\Pivots\Tags;

use BristolSU\ControlDB\Cache\Pivots\Tags\PositionPositionTag as PositionPositionTagCache;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use Illuminate\Contracts\Cache\Repository;

class PositionPositionTagObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function addTagToPosition(PositionTag $positionTag, Position $position): void
    {
        $this->cache->forget(PositionPositionTagCache::class . '@getTagsThroughPosition:' . $position->id());
        $this->cache->forget(PositionPositionTagCache::class . '@getPositionsThroughTag:' . $positionTag->id());
    }

    public function removeTagFromPosition(PositionTag $positionTag, Position $position): void
    {
        $this->cache->forget(PositionPositionTagCache::class . '@getTagsThroughPosition:' . $position->id());
        $this->cache->forget(PositionPositionTagCache::class . '@getPositionsThroughTag:' . $positionTag->id());
    }

}