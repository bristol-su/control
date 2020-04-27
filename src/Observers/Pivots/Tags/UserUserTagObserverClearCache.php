<?php

namespace BristolSU\ControlDB\Observers\Pivots\Tags;

use BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag as UserUserTagCache;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use Illuminate\Contracts\Cache\Repository;

class UserUserTagObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function addTagToUser(UserTag $userTag, User $user): void
    {
        $this->cache->forget(UserUserTagCache::class . '@getTagsThroughUser:' . $user->id());
        $this->cache->forget(UserUserTagCache::class . '@getUsersThroughTag:' . $userTag->id());
    }

    public function removeTagFromUser(UserTag $userTag, User $user): void
    {
        $this->cache->forget(UserUserTagCache::class . '@getTagsThroughUser:' . $user->id());
        $this->cache->forget(UserUserTagCache::class . '@getUsersThroughTag:' . $userTag->id());
    }

}