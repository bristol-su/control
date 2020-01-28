<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory;
use Illuminate\Support\Collection;

trait RoleTagTrait
{

    /**
     * Full reference of the tag
     *
     * This should be the tag category reference and the tag reference, separated with a period.
     * @return string
     */
    public function fullReference(): string
    {
        return $this->category()->reference() . '.' . $this->reference();
    }

    /**
     * Tag Category
     *
     * @return RoleTagCategory
     */
    public function category(): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory
    {
        return app(RoleTagCategory::class)->getById($this->id());
    }

    /**
     * Roles who have this tag
     *
     * @return Collection
     */
    public function roles(): Collection
    {
        return app(RoleRoleTag::class)->getRolesThroughTag($this);
    }

    public function addRole(Role $role): void
    {
        app(RoleRoleTag::class)->addTagToRole($this, $role);
    }

    public function removeRole(Role $role): void
    {
        app(RoleRoleTag::class)->removeTagFromRole($this, $role);
    }
    
}