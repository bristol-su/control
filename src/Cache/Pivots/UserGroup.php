<?php

namespace BristolSU\ControlDB\Cache\Pivots;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup as UserGroupContract;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class UserGroup implements UserGroupContract
{

    /**
     * @var UserGroupContract
     */
    private $userGroup;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(UserGroupContract $userGroup, Repository $cache)
    {
        $this->userGroup = $userGroup;
        $this->cache = $cache;
    }

    /**
     * Get all users who are members of a group
     *
     * @param Group $group
     * @return User[]|Collection Users who are members of the group
     */
    public function getUsersThroughGroup(Group $group): Collection
    {
        return $this->cache->rememberForever(static::class . '@getUsersThroughGroup:' . $group->id(), function() use ($group) {
            return $this->userGroup->getUsersThroughGroup($group);
        });
    }

    /**
     * Get all groups a user belongs to
     *
     * @param User $user
     * @return Group[]|Collection Groups the user is a member of
     */
    public function getGroupsThroughUser(User $user): Collection
    {
        return $this->cache->rememberForever(static::class . '@getGroupsThroughUser:' . $user->id(), function() use ($user) {
            return $this->userGroup->getGroupsThroughUser($user);
        });    
    }

    /**
     * Add a user to a group
     *
     * @param User $user User to add to the group
     * @param Group $group Group to add the user to
     * @return void
     */
    public function addUserToGroup(User $user, Group $group): void
    {
        $this->userGroup->addUserToGroup($user, $group);
    }

    /**
     * Remove a user from a group
     * @param User $user User to remove from the group
     * @param Group $group Group to remove the user from
     * @return void
     */
    public function removeUserFromGroup(User $user, Group $group): void
    {
        $this->userGroup->removeUserFromGroup($user, $group);
    }
}