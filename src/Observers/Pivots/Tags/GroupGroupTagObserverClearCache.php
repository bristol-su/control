<?php

namespace BristolSU\ControlDB\Observers\Pivots\Tags;

use BristolSU\ControlDB\Cache\Pivots\Tags\GroupGroupTag as GroupGroupTagCache;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use Illuminate\Contracts\Cache\Repository;

class GroupGroupTagObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function addTagToGroup(GroupTag $groupTag, Group $group): void
    {
        $this->cache->forget(GroupGroupTagCache::class . '@getTagsThroughGroup:' . $group->id());
        $this->cache->forget(GroupGroupTagCache::class . '@getGroupsThroughTag:' . $groupTag->id());
    }

    public function removeTagFromGroup(GroupTag $groupTag, Group $group): void
    {
        $this->cache->forget(GroupGroupTagCache::class . '@getTagsThroughGroup:' . $group->id());
        $this->cache->forget(GroupGroupTagCache::class . '@getGroupsThroughTag:' . $groupTag->id());
    }

}