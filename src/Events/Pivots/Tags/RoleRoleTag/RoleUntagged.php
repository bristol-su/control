<?php

namespace BristolSU\ControlDB\Events\Pivots\Tags\RoleRoleTag;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Models\Role;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleUntagged
{
    use Dispatchable, SerializesModels;

    public Role $role;
    public RoleTag $roleTag;

    public function __construct(Role $role, RoleTag $roleTag)
    {
        $this->role = $role;
        $this->roleTag = $roleTag;
    }

}
