<?php

namespace BristolSU\ControlDB\Observers\Pivots;

use BristolSU\ControlDB\Cache\Pivots\UserGroup as UserGroupCache;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Contracts\Cache\Repository;

class UserGroupObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function addUserToGroup(User $user, Group $group)
    {
        $this->cache->forget(UserGroupCache::class . '@getGroupsThroughUser:' . $user->id());
        $this->cache->forget(UserGroupCache::class . '@getUsersThroughGroup:' . $group->id());
    }

    public function removeUserFromGroup(User $user, Group $group): void
    {
        $this->cache->forget(UserGroupCache::class . '@getGroupsThroughUser:' . $user->id());
        $this->cache->forget(UserGroupCache::class . '@getUsersThroughGroup:' . $group->id());
    }

}