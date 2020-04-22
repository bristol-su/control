<?php

namespace BristolSU\ControlDB\Http\Controllers\Role;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;

/**
 * Handle the tagging and untagging of roles
 */
class RoleRoleTagController extends Controller
{

    /**
     * Get all tags belonging to the current role
     *
     * @param Role $role
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Role $role)
    {
        return $this->paginate($role->tags());
    }

    /**
     * Tag a role
     *
     * @param Role $role
     * @param RoleTag $roleTag
     */
    public function update(Role $role, RoleTag $roleTag)
    {
        $role->addTag($roleTag);
    }

    /**
     * Untag role
     *
     * @param Role $role
     * @param RoleTag $roleTag
     */
    public function destroy(Role $role, RoleTag $roleTag)
    {
        $role->removeTag($roleTag);
    }

}
