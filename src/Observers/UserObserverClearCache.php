<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Cache\User as UserCache;
use BristolSU\ControlDB\Contracts\Models\User as UserModel;
use Illuminate\Contracts\Cache\Repository;

class UserObserverClearCache
{

    /**
     * @var Repository
     */
    private $cache;

    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    public function create(UserModel $userModel)
    {
        $this->cache->forget(UserCache::class . '@count');
        $this->cache->forget(UserCache::class . '@getByDataProviderId:' . $userModel->dataProviderId());
    }

    public function delete(UserModel $user)
    {
        $this->cache->forget(UserCache::class . '@count');
        $this->cache->forget(UserCache::class . '@getById:' . $user->id());
        $this->cache->forget(UserCache::class . '@getByDataProviderId:' . $user->dataProviderId());
    }

    public function update(UserModel $oldUser, UserModel $newUser)
    {
        $this->cache->forget(UserCache::class . '@count');
        $this->cache->forget(UserCache::class . '@getById:' . $newUser->id());
        $this->cache->forget(UserCache::class . '@getByDataProviderId:' . $oldUser->dataProviderId());
        $this->cache->forget(UserCache::class . '@getByDataProviderId:' . $newUser->dataProviderId());
    }
    
}