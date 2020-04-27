<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Cache\Group as GroupCache;
use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use Illuminate\Contracts\Cache\Repository;

class GroupObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function create(GroupModel $groupModel)
    {
        $this->cache->forget(GroupCache::class . '@count');
        $this->cache->forget(GroupCache::class . '@getByDataProviderId:' . $groupModel->dataProviderId());
    }

    public function delete(GroupModel $group)
    {
        $this->cache->forget(GroupCache::class . '@count');
        $this->cache->forget(GroupCache::class . '@getById:' . $group->id());
        $this->cache->forget(GroupCache::class . '@getByDataProviderId:' . $group->dataProviderId());
    }

    public function update(GroupModel $oldGroup, GroupModel $newGroup)
    {
        $this->cache->forget(GroupCache::class . '@count');
        $this->cache->forget(GroupCache::class . '@getById:' . $newGroup->id());
        $this->cache->forget(GroupCache::class . '@getByDataProviderId:' . $oldGroup->dataProviderId());
        $this->cache->forget(GroupCache::class . '@getByDataProviderId:' . $newGroup->dataProviderId());
    }
    
}