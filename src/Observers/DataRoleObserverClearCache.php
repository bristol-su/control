<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Cache\DataRole as DataRoleCache;
use BristolSU\ControlDB\Contracts\Models\DataRole;
use Illuminate\Contracts\Cache\Repository;

class DataRoleObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function update(DataRole $oldDataRole, DataRole $newDataRole)
    {
        $this->cache->forget(DataRoleCache::class . '@getById:' . $newDataRole->id());
    }

}