<?php

namespace BristolSU\ControlDB\Events\Pivots\Tags\RoleRoleTag;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;
use Illuminate\Support\Collection;

class RoleRoleTagEventDispatcher implements RoleRoleTag
{

    private RoleRoleTag $baseRoleRoleTag;

    public function __construct(RoleRoleTag $baseRoleRoleTag)
    {
        $this->baseRoleRoleTag = $baseRoleRoleTag;
    }

    public function addTagToRole(RoleTag $roleTag, Role $role): void
    {
        $this->baseRoleRoleTag->addTagToRole($roleTag, $role);
        RoleTagged::dispatch($role, $roleTag);
    }

    public function removeTagFromRole(RoleTag $roleTag, Role $role): void
    {
        $this->baseRoleRoleTag->removeTagFromRole($roleTag, $role);
        RoleUntagged::dispatch($role, $roleTag);
    }

    public function getTagsThroughRole(Role $role): Collection
    {
        return $this->baseRoleRoleTag->getTagsThroughRole($role);
    }

    public function getRolesThroughTag(RoleTag $roleTag): Collection
    {
        return $this->baseRoleRoleTag->getRolesThroughTag($roleTag);
    }
}
