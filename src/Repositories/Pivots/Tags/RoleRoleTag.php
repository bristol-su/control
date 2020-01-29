<?php

namespace BristolSU\ControlDB\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag as RoleRoleTagContract;
use Illuminate\Support\Collection;

/**
 * Handles the tagging of roles
 */
class RoleRoleTag implements RoleRoleTagContract
{

    /**
     * Tag a role
     *
     * @param RoleTag $roleTag Tag to tag the role with
     * @param Role $role Role to tag
     * @return void
     */
    public function addTagToRole(RoleTag $roleTag, Role $role): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\RoleRoleTag::create([
            'tag_id' => $roleTag->id(), 'taggable_id' => $role->id()
        ]);
    }

    /**
     * Remove a tag from a role
     *
     * @param RoleTag $roleTag Tag to remove from the role
     * @param Role $role Role to remove the tag from
     * @return void
     */
    public function removeTagFromRole(RoleTag $roleTag, Role $role): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\RoleRoleTag::where([
            'tag_id' => $roleTag->id(), 'taggable_id' => $role->id()
        ])->delete();    
    }

    /**
     * Get all tags a role is tagged with
     *
     * @param Role $role Role to retrieve tags from
     * @return Collection|RoleTag[] Tags the role is tagged with
     */
    public function getTagsThroughRole(Role $role): Collection
    {
        $roleTagRepository = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag::class);

        return \BristolSU\ControlDB\Models\Pivots\Tags\RoleRoleTag::where('taggable_id', $role->id())
            ->get()->map(function(\BristolSU\ControlDB\Models\Pivots\Tags\RoleRoleTag $roleRoleTag) use ($roleTagRepository) {
            return $roleTagRepository->getById((int) $roleRoleTag->tag_id);
        })->unique(function(RoleTag $user) {
            return $user->id();
        })->values();
    }

    /**
     * Get all roles tagged with a tag
     *
     * @param RoleTag $roleTag Tag to use to retrieve roles
     * @return Collection|Role[] Roles tagged with the given tag
     */
    public function getRolesThroughTag(RoleTag $roleTag): Collection
    {
        $roleRepository = app(\BristolSU\ControlDB\Contracts\Repositories\Role::class);

        return \BristolSU\ControlDB\Models\Pivots\Tags\RoleRoleTag::where('tag_id', $roleTag->id())
            ->get()->map(function(\BristolSU\ControlDB\Models\Pivots\Tags\RoleRoleTag $roleRoleTag) use ($roleRepository) {
                return $roleRepository->getById((int) $roleRoleTag->taggable_id);
            })->unique(function(Role $role) {
                return $role->id();
            })->values();
    }
}