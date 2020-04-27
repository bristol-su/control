<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Cache\Tags\GroupTag as GroupTagCache;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use Illuminate\Contracts\Cache\Repository;

class GroupTagObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function delete(GroupTag $groupTag)
    {
        $this->cache->forget(GroupTagCache::class . '@allThroughTagCategory:' . $groupTag->categoryId());
        $this->cache->forget(GroupTagCache::class . '@getById:' . $groupTag->id());
        $this->cache->forget(GroupTagCache::class . '@getTagByFullReference:' . $groupTag->fullReference());
    }

    public function create(GroupTag $groupTag)
    {
        return $this->cache->forget(GroupTagCache::class . '@allThroughTagCategory:' . $groupTag->categoryId());
    }

    public function update(GroupTag $oldGroupTag, GroupTag $newGroupTag)
    {
        $this->cache->forget(GroupTagCache::class . '@getById:' . $newGroupTag->id());
        $this->cache->forget(GroupTagCache::class . '@getTagByFullReference:' . $oldGroupTag->fullReference());
        $this->cache->forget(GroupTagCache::class . '@getTagByFullReference:' . $newGroupTag->fullReference());
        $this->cache->forget(GroupTagCache::class . '@allThroughTagCategory:' . $oldGroupTag->categoryId());
        $this->cache->forget(GroupTagCache::class . '@allThroughTagCategory:' . $newGroupTag->categoryId());        
    }

}