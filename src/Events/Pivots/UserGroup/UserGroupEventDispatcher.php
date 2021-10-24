<?php

namespace BristolSU\Control\Events\Pivots\UserGroup;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use Illuminate\Support\Collection;

class UserGroupEventDispatcher implements UserGroup
{

    private UserGroup $baseUserGroup;

    public function __construct(UserGroup $baseUserGroup)
    {
        $this->baseUserGroup = $baseUserGroup;
    }

    public function getUsersThroughGroup(Group $group): Collection
    {
        return $this->baseUserGroup->getUsersThroughGroup($group);
    }

    public function getGroupsThroughUser(User $user): Collection
    {
        return $this->baseUserGroup->getGroupsThroughUser($user);
    }

    public function addUserToGroup(User $user, Group $group): void
    {
        $this->baseUserGroup->addUserToGroup($user, $group);
        UserAddedToGroup::dispatch($user, $group);
    }

    public function removeUserFromGroup(User $user, Group $group): void
    {
        $this->baseUserGroup->removeUserFromGroup($user, $group);
        UserRemovedFromGroup::dispatch($user, $group);
    }
}
