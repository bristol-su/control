<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Cache\Tags\PositionTag as PositionTagCache;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use Illuminate\Contracts\Cache\Repository;

class PositionTagObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function delete(PositionTag $positionTag)
    {
        $this->cache->forget(PositionTagCache::class . '@allThroughTagCategory:' . $positionTag->categoryId());
        $this->cache->forget(PositionTagCache::class . '@getById:' . $positionTag->id());
        $this->cache->forget(PositionTagCache::class . '@getTagByFullReference:' . $positionTag->fullReference());
    }

    public function create(PositionTag $positionTag)
    {
        return $this->cache->forget(PositionTagCache::class . '@allThroughTagCategory:' . $positionTag->categoryId());
    }

    public function update(PositionTag $oldPositionTag, PositionTag $newPositionTag)
    {
        $this->cache->forget(PositionTagCache::class . '@getById:' . $newPositionTag->id());
        $this->cache->forget(PositionTagCache::class . '@getTagByFullReference:' . $oldPositionTag->fullReference());
        $this->cache->forget(PositionTagCache::class . '@getTagByFullReference:' . $newPositionTag->fullReference());
        $this->cache->forget(PositionTagCache::class . '@allThroughTagCategory:' . $oldPositionTag->categoryId());
        $this->cache->forget(PositionTagCache::class . '@allThroughTagCategory:' . $newPositionTag->categoryId());        
    }

}