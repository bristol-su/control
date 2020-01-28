<?php

namespace BristolSU\ControlDB\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag as RoleRoleTagContract;
use Illuminate\Support\Collection;

class RoleRoleTag implements RoleRoleTagContract
{

    /**
     * @inheritDoc
     */
    public function addTagToRole(RoleTag $roleTag, Role $role): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\RoleRoleTag::create([
            'tag_id' => $roleTag->id(), 'taggable_id' => $role->id()
        ]);
    }

    /**
     * @inheritDoc
     */
    public function removeTagFromRole(RoleTag $roleTag, Role $role): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\RoleRoleTag::where([
            'tag_id' => $roleTag->id(), 'taggable_id' => $role->id()
        ])->delete();    
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
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