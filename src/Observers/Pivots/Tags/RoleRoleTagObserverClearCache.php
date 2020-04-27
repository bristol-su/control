<?php

namespace BristolSU\ControlDB\Observers\Pivots\Tags;

use BristolSU\ControlDB\Cache\Pivots\Tags\RoleRoleTag as RoleRoleTagCache;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use Illuminate\Contracts\Cache\Repository;

class RoleRoleTagObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function addTagToRole(RoleTag $roleTag, Role $role): void
    {
        $this->cache->forget(RoleRoleTagCache::class . '@getTagsThroughRole:' . $role->id());
        $this->cache->forget(RoleRoleTagCache::class . '@getRolesThroughTag:' . $roleTag->id());
    }

    public function removeTagFromRole(RoleTag $roleTag, Role $role): void
    {
        $this->cache->forget(RoleRoleTagCache::class . '@getTagsThroughRole:' . $role->id());
        $this->cache->forget(RoleRoleTagCache::class . '@getRolesThroughTag:' . $roleTag->id());
    }

}