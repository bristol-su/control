<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Cache\Tags\PositionTagCategory as PositionTagCategoryCache;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory;
use Illuminate\Contracts\Cache\Repository;

class PositionTagCategoryObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function delete(PositionTagCategory $positionTagCategory)
    {
        $this->cache->forget(PositionTagCategoryCache::class . '@getByReference:' . $positionTagCategory->reference());
        $this->cache->forget(PositionTagCategoryCache::class . '@getById: ' . $positionTagCategory->id());
    }

    public function update(PositionTagCategory $oldPositionTagCategory, PositionTagCategory $newPositionTagCategory)
    {
        $this->cache->forget(PositionTagCategoryCache::class . '@getById:' . $newPositionTagCategory->id());
        $this->cache->forget(PositionTagCategoryCache::class . '@getByReference:' . $newPositionTagCategory->reference());
        $this->cache->forget(PositionTagCategoryCache::class . '@getByReference:' . $oldPositionTagCategory->reference());
    }

}