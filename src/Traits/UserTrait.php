<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\DataUser;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Tags\UserTag;
use Illuminate\Support\Collection;

/**
 * Implements common methods using repositories required by the user model interface
 */
trait UserTrait
{

    /**
     * Get the attributes for this user
     *
     * @return DataUser
     */
    public function data(): DataUser {
        return app(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class)->getById($this->dataProviderId());
    }

    /**
     * Tags the user is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return app(UserUserTag::class)->getTagsThroughUser($this);
    }

    /**
     * Roles the user owns
     *
     * @return Collection
     */
    public function roles(): Collection
    {
        return app(UserRole::class)->getRolesThroughUser($this);
    }

    /**
     * Groups the user is a member of
     *
     * @return Collection
     */
    public function groups(): Collection
    {
        return app(UserGroup::class)->getGroupsThroughUser($this);
    }

    /**
     * Add a tag to the user
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\UserTag $userTag
     */
    public function addTag(\BristolSU\ControlDB\Contracts\Models\Tags\UserTag $userTag): void
    {
        app(UserUserTag::class)->addTagToUser($userTag, $this);
    }

    /**
     * Remove a tag from the user
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\UserTag $userTag
     */
    public function removeTag(\BristolSU\ControlDB\Contracts\Models\Tags\UserTag $userTag): void
    {
        app(UserUserTag::class)->removeTagFromUser($userTag, $this);
    }

    /**
     * Add a role to the user
     * 
     * @param Role $role
     */
    public function addRole(Role $role): void
    {
        app(UserRole::class)->addUserToRole($this, $role);
    }

    /**
     * Remove a role from the user
     * 
     * @param Role $role
     */
    public function removeRole(Role $role): void
    {
        app(UserRole::class)->removeUserFromRole($this, $role);
    }

    /**
     * Add a group to the user
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Group $group
     */
    public function addGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): void
    {
        app(UserGroup::class)->addUserToGroup($this, $group);
    }

    /**
     * Remove a group from the user
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Group $group
     */
    public function removeGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): void
    {
        app(UserGroup::class)->removeUserFromGroup($this, $group);
    }
    
    
}