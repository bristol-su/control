<?php

namespace BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use Illuminate\Support\Collection;

/**
 * Handles the tagging of roles
 */
interface RoleRoleTag
{

    /**
     * Tag a role
     *
     * @param RoleTag $roleTag Tag to tag the role with
     * @param Role $role Role to tag
     * @return void 
     */
    public function addTagToRole(RoleTag $roleTag, Role $role): void;

    /**
     * Remove a tag from a role
     *
     * @param RoleTag $roleTag Tag to remove from the role
     * @param Role $role Role to remove the tag from
     * @return void 
     */
    public function removeTagFromRole(RoleTag $roleTag, Role $role): void;

    /**
     * Get all tags a role is tagged with
     *
     * @param Role $role Role to retrieve tags from
     * @return Collection|RoleTag[] Tags the role is tagged with
     */
    public function getTagsThroughRole(Role $role): Collection;

    /**
     * Get all roles tagged with a tag
     *
     * @param RoleTag $roleTag Tag to use to retrieve roles
     * @return Collection|Role[] Roles tagged with the given tag
     */
    public function getRolesThroughTag(RoleTag $roleTag): Collection;

}