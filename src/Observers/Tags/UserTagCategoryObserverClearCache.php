<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Cache\Tags\UserTagCategory as UserTagCategoryCache;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory;
use Illuminate\Contracts\Cache\Repository;

class UserTagCategoryObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function delete(UserTagCategory $userTagCategory)
    {
        $this->cache->forget(UserTagCategoryCache::class . '@getByReference:' . $userTagCategory->reference());
        $this->cache->forget(UserTagCategoryCache::class . '@getById: ' . $userTagCategory->id());
    }

    public function update(UserTagCategory $oldUserTagCategory, UserTagCategory $newUserTagCategory)
    {
        $this->cache->forget(UserTagCategoryCache::class . '@getById:' . $newUserTagCategory->id());
        $this->cache->forget(UserTagCategoryCache::class . '@getByReference:' . $newUserTagCategory->reference());
        $this->cache->forget(UserTagCategoryCache::class . '@getByReference:' . $oldUserTagCategory->reference());
    }

}