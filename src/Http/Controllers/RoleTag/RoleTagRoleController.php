<?php

namespace BristolSU\ControlDB\Http\Controllers\RoleTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Models\Role;

/**
 * Handle the link between a role tag and a role
 */
class RoleTagRoleController extends Controller
{
    /**
     * Get all roles with the given tag
     * 
     * @param RoleTag $roleTag
     * @return \Illuminate\Support\Collection
     */
    public function index(RoleTag $roleTag)
    {
        return $roleTag->roles();
    }

    /**
     * Add the role to the tag
     * 
     * @param RoleTag $roleTag
     * @param Role $role
     */
    public function update(RoleTag $roleTag, Role $role)
    {
        $roleTag->addRole($role);
    }

    /**
     * Remove the role from the tag
     * 
     * @param RoleTag $roleTag
     * @param Role $role
     */
    public function destroy(RoleTag $roleTag, Role $role)
    {
        $roleTag->removeRole($role);
    }

}
