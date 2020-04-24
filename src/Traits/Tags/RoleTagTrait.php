<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory;
use Illuminate\Support\Collection;

/**
 * Supplies implementations of common functions required by a role tag model by resolving repositories.
 */
trait RoleTagTrait
{

    /**
     * Get the role tag category of the role tag
     *
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory
     */
    public function category(): \BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory
    {
        return app(RoleTagCategory::class)->getById($this->categoryId());
    }

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
     * Roles who have this tag
     *
     * @return Collection
     */
    public function roles(): Collection
    {
        return app(RoleRoleTag::class)->getRolesThroughTag($this);
    }

    /**
     * Tag a role with the role tag
     *
     * @param Role $role
     */
    public function addRole(Role $role): void
    {
        app(RoleRoleTag::class)->addTagToRole($this, $role);
    }

    /**
     * Untag a role from the role tag
     *
     * @param Role $role
     */
    public function removeRole(Role $role): void
    {
        app(RoleRoleTag::class)->removeTagFromRole($this, $role);
    }

    /**
     * Set the name of the tag
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        app(RoleTag::class)->update($this->id(), $name, $this->description(), $this->reference(), $this->categoryId());
    }

    /**
     * Set the description of the Tag
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        app(RoleTag::class)->update($this->id(), $this->name(), $description, $this->reference(), $this->categoryId());
    }

    /**
     * Set the reference of the tag
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        app(RoleTag::class)->update($this->id(), $this->name(), $this->description(), $reference, $this->categoryId());
    }

    /**
     * Set the tag category ID
     *
     * @param int $categoryId
     */
    public function setTagCategoryId($categoryId): void
    {
        app(RoleTag::class)->update($this->id(), $this->name(), $this->description(), $this->reference(), $categoryId);
    }
}