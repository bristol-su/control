<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Cache\DataPosition as DataPositionCache;
use BristolSU\ControlDB\Contracts\Models\DataPosition;
use Illuminate\Contracts\Cache\Repository;

class DataPositionObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function update(DataPosition $oldDataPosition, DataPosition $newDataPosition)
    {
        $this->cache->forget(DataPositionCache::class . '@getById:' . $newDataPosition->id());
    }

}