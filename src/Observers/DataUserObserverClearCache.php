<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Cache\DataUser as DataUserCache;
use BristolSU\ControlDB\Contracts\Models\DataUser;
use Illuminate\Contracts\Cache\Repository;

class DataUserObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function update(DataUser $oldDataUser, DataUser $newDataUser)
    {
        $this->cache->forget(DataUserCache::class . '@getById:' . $newDataUser->id());
    }

}