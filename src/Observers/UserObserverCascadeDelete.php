<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Cache\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;

class UserObserverCascadeDelete
{

    /**
     * @var UserGroup
     */
    private $userGroup;
    /**
     * @var UserUserTag
     */
    private $userUserTag;
    /**
     * @var UserRole
     */
    private $userRole;

    public function __construct(UserGroup $userGroup, UserRole $userRole, UserUserTag $userUserTag)
    {
        $this->userGroup = $userGroup;
        $this->userUserTag = $userUserTag;
        $this->userRole = $userRole;
    }

    public function delete(User $user)
    {
        $this->removeGroups($user);
        $this->removeTags($user);
        $this->removeRoles($user);
    }

    private function removeGroups(User $user)
    {
        foreach($this->userGroup->getGroupsThroughUser($user) as $group) {
            $this->userGroup->removeUserFromGroup($user, $group);
        }
    }

    private function removeTags(User $user)
    {
        foreach($this->userUserTag->getTagsThroughUser($user) as $tag) {
            $this->userUserTag->removeTagFromUser($tag, $user);
        }
    }

    private function removeRoles(User $user)
    {
        foreach($this->userRole->getRolesThroughUser($user) as $role) {
            $this->userRole->removeUserFromRole($user, $role);
        }
    }

}