<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;

class RoleTagObserverCascadeDelete
{

    /**
     * @var RoleRoleTag
     */
    private $roleRoleTag;

    public function __construct(RoleRoleTag $roleRoleTag)
    {
        $this->roleRoleTag = $roleRoleTag;
    }

    public function delete(RoleTag $roleTag)
    {
        $roles = $this->roleRoleTag->getRolesThroughTag($roleTag);
        foreach($roles as $role) {
            $this->roleRoleTag->removeTagFromRole($roleTag, $role);
        }
    }
    
}