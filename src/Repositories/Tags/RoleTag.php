<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\Support\Control\Contracts\Models\Role;
use BristolSU\Support\Control\Contracts\Models\Tags\RoleTagCategory;
use BristolSU\Support\Control\Contracts\Repositories\Tags\RoleTag as RoleTagContract;
use Illuminate\Support\Collection;

/**
 * Class RoleTag
 * @package BristolSU\ControlDB\Repositories
 */
class RoleTag implements RoleTagContract
{
    /**
     * Get all role tags
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTag::all();
    }

    /**
     * Get all role tags which a role is tagged with
     *
     * @param Role $role
     * @return Collection
     */
    public function allThroughRole(Role $role): Collection
    {
        return $role->tags();
    }

    /**
     * Get a tag by the full reference
     *
     * @param string $reference
     * @return mixed
     */
    public function getTagByFullReference(string $reference): \BristolSU\Support\Control\Contracts\Models\Tags\RoleTag
    {
        return $this->all()->filter(function(\BristolSU\ControlDB\Models\Tags\RoleTag $tag) use ($reference) {
            return $reference === $tag->fullReference();
        })->firstOrFail();
    }

    /**
     * Get a role tag by id
     *
     * @param int $id
     * @return \BristolSU\Support\Control\Contracts\Models\Tags\RoleTag
     */
    public function getById(int $id): \BristolSU\Support\Control\Contracts\Models\Tags\RoleTag
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTag::findOrFail($id);
    }

    /**
     * Get all role tags belonging to a role tag category
     *
     * @param RoleTagCategory $roleTagCategory
     * @return Collection
     */
    public function allThroughRoleTagCategory(RoleTagCategory $roleTagCategory): Collection
    {
        return $roleTagCategory->tags();
    }
}
