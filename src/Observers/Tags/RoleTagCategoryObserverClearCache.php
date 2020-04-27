<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Cache\Tags\RoleTagCategory as RoleTagCategoryCache;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory;
use Illuminate\Contracts\Cache\Repository;

class RoleTagCategoryObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function delete(RoleTagCategory $roleTagCategory)
    {
        $this->cache->forget(RoleTagCategoryCache::class . '@getByReference:' . $roleTagCategory->reference());
        $this->cache->forget(RoleTagCategoryCache::class . '@getById: ' . $roleTagCategory->id());
    }

    public function update(RoleTagCategory $oldRoleTagCategory, RoleTagCategory $newRoleTagCategory)
    {
        $this->cache->forget(RoleTagCategoryCache::class . '@getById:' . $newRoleTagCategory->id());
        $this->cache->forget(RoleTagCategoryCache::class . '@getByReference:' . $newRoleTagCategory->reference());
        $this->cache->forget(RoleTagCategoryCache::class . '@getByReference:' . $oldRoleTagCategory->reference());
    }

}