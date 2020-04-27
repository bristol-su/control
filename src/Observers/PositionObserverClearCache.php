<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Cache\Position as PositionCache;
use BristolSU\ControlDB\Contracts\Models\Position as PositionModel;
use Illuminate\Contracts\Cache\Repository;

class PositionObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function create(PositionModel $positionModel)
    {
        $this->cache->forget(PositionCache::class . '@count');
        $this->cache->forget(PositionCache::class . '@getByDataProviderId:' . $positionModel->dataProviderId());
    }

    public function delete(PositionModel $position)
    {
        $this->cache->forget(PositionCache::class . '@count');
        $this->cache->forget(PositionCache::class . '@getById:' . $position->id());
        $this->cache->forget(PositionCache::class . '@getByDataProviderId:' . $position->dataProviderId());
    }

    public function update(PositionModel $oldPosition, PositionModel $newPosition)
    {
        $this->cache->forget(PositionCache::class . '@count');
        $this->cache->forget(PositionCache::class . '@getById:' . $newPosition->id());
        $this->cache->forget(PositionCache::class . '@getByDataProviderId:' . $oldPosition->dataProviderId());
        $this->cache->forget(PositionCache::class . '@getByDataProviderId:' . $newPosition->dataProviderId());
    }
    
}