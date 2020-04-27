<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Cache\Tags\GroupTagCategory as GroupTagCategoryCache;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory;
use Illuminate\Contracts\Cache\Repository;

class GroupTagCategoryObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function delete(GroupTagCategory $groupTagCategory)
    {
        $this->cache->forget(GroupTagCategoryCache::class . '@getByReference:' . $groupTagCategory->reference());
        $this->cache->forget(GroupTagCategoryCache::class . '@getById: ' . $groupTagCategory->id());
    }

    public function update(GroupTagCategory $oldGroupTagCategory, GroupTagCategory $newGroupTagCategory)
    {
        $this->cache->forget(GroupTagCategoryCache::class . '@getById:' . $newGroupTagCategory->id());
        $this->cache->forget(GroupTagCategoryCache::class . '@getByReference:' . $newGroupTagCategory->reference());
        $this->cache->forget(GroupTagCategoryCache::class . '@getByReference:' . $oldGroupTagCategory->reference());
    }

}