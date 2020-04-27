<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Cache\DataGroup as DataGroupCache;
use BristolSU\ControlDB\Contracts\Models\DataGroup;
use Illuminate\Contracts\Cache\Repository;

class DataGroupObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function update(DataGroup $oldDataGroup, DataGroup $newDataGroup)
    {
        $this->cache->forget(DataGroupCache::class . '@getById:' . $newDataGroup->id());
    }

}