<?php

namespace BristolSU\ControlDB\Observers;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;

class RoleObserverCascadeDelete
{

    /**
     * @var UserRole
     */
    private $userRole;
    /**
     * @var RoleRoleTag
     */
    private $roleRoleTag;

    public function __construct(UserRole $userRole, RoleRoleTag $roleRoleTag)
    {
        $this->userRole = $userRole;
        $this->roleRoleTag = $roleRoleTag;
    }

    public function delete(Role $role)
    {
        $this->removeUsers($role);
        $this->removeTags($role);
    }

    private function removeUsers(Role $role)
    {
        foreach($this->userRole->getUsersThroughRole($role) as $user) {
            $this->userRole->removeUserFromRole($user, $role);
        }
    }

    private function removeTags(Role $role)
    {
        foreach($this->roleRoleTag->getTagsThroughRole($role) as $tag) {
            $this->roleRoleTag->removeTagFromRole($tag, $role);
        }
    }

}