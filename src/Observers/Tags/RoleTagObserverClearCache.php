<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Cache\Tags\RoleTag as RoleTagCache;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use Illuminate\Contracts\Cache\Repository;

class RoleTagObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function delete(RoleTag $roleTag)
    {
        $this->cache->forget(RoleTagCache::class . '@allThroughTagCategory:' . $roleTag->categoryId());
        $this->cache->forget(RoleTagCache::class . '@getById:' . $roleTag->id());
        $this->cache->forget(RoleTagCache::class . '@getTagByFullReference:' . $roleTag->fullReference());
    }

    public function create(RoleTag $roleTag)
    {
        return $this->cache->forget(RoleTagCache::class . '@allThroughTagCategory:' . $roleTag->categoryId());
    }

    public function update(RoleTag $oldRoleTag, RoleTag $newRoleTag)
    {
        $this->cache->forget(RoleTagCache::class . '@getById:' . $newRoleTag->id());
        $this->cache->forget(RoleTagCache::class . '@getTagByFullReference:' . $oldRoleTag->fullReference());
        $this->cache->forget(RoleTagCache::class . '@getTagByFullReference:' . $newRoleTag->fullReference());
        $this->cache->forget(RoleTagCache::class . '@allThroughTagCategory:' . $oldRoleTag->categoryId());
        $this->cache->forget(RoleTagCache::class . '@allThroughTagCategory:' . $newRoleTag->categoryId());        
    }

}