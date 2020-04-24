<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Cache\Role as RoleCache;
use BristolSU\ControlDB\Contracts\Models\Role as RoleModel;
use Illuminate\Contracts\Cache\Repository;

class RoleObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function create(RoleModel $roleModel)
    {
        $this->cache->forget(RoleCache::class . '@count');
        $this->cache->forget(RoleCache::class . '@getByDataProviderId:' . $roleModel->dataProviderId());
        $this->cache->forget(RoleCache::class . '@allThroughGroup:' . $roleModel->groupId());
        $this->cache->forget(RoleCache::class . '@allThroughPosition:' . $roleModel->positionId());
    }

    public function delete(RoleModel $role)
    {
        $this->cache->forget(RoleCache::class . '@count');
        $this->cache->forget(RoleCache::class . '@getById:' . $role->id());
        $this->cache->forget(RoleCache::class . '@getByDataProviderId:' . $role->dataProviderId());
        $this->cache->forget(RoleCache::class . '@allThroughGroup:' . $role->groupId());
        $this->cache->forget(RoleCache::class . '@allThroughPosition:' . $role->positionId());
    }

    public function update(RoleModel $oldRole, RoleModel $newRole)
    {
        $this->cache->forget(RoleCache::class . '@count');
        $this->cache->forget(RoleCache::class . '@getById:' . $newRole->id());
        $this->cache->forget(RoleCache::class . '@getByDataProviderId:' . $oldRole->dataProviderId());
        $this->cache->forget(RoleCache::class . '@getByDataProviderId:' . $newRole->dataProviderId());
        $this->cache->forget(RoleCache::class . '@allThroughPosition:' . $oldRole->positionId());
        $this->cache->forget(RoleCache::class . '@allThroughPosition:' . $newRole->positionId());
        $this->cache->forget(RoleCache::class . '@allThroughGroup:' . $oldRole->groupId());
        $this->cache->forget(RoleCache::class . '@allThroughGroup:' . $newRole->groupId());
    }
    
}