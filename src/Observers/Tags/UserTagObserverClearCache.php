<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Cache\Tags\UserTag as UserTagCache;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use Illuminate\Contracts\Cache\Repository;

class UserTagObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function delete(UserTag $userTag)
    {
        $this->cache->forget(UserTagCache::class . '@allThroughTagCategory:' . $userTag->categoryId());
        $this->cache->forget(UserTagCache::class . '@getById:' . $userTag->id());
        $this->cache->forget(UserTagCache::class . '@getTagByFullReference:' . $userTag->fullReference());
    }

    public function create(UserTag $userTag)
    {
        return $this->cache->forget(UserTagCache::class . '@allThroughTagCategory:' . $userTag->categoryId());
    }

    public function update(UserTag $oldUserTag, UserTag $newUserTag)
    {
        $this->cache->forget(UserTagCache::class . '@getById:' . $newUserTag->id());
        $this->cache->forget(UserTagCache::class . '@getTagByFullReference:' . $oldUserTag->fullReference());
        $this->cache->forget(UserTagCache::class . '@getTagByFullReference:' . $newUserTag->fullReference());
        $this->cache->forget(UserTagCache::class . '@allThroughTagCategory:' . $oldUserTag->categoryId());
        $this->cache->forget(UserTagCache::class . '@allThroughTagCategory:' . $newUserTag->categoryId());        
    }

}