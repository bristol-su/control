<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Tags\UserTag;
use Illuminate\Support\Collection;

trait UserTrait
{

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

    public function data(): \BristolSU\ControlDB\Contracts\Models\DataUser {
        return app(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class)->getById($this->dataProviderId());
    }

    public function addTag(\BristolSU\ControlDB\Contracts\Models\Tags\UserTag $userTag): void
    {
        app(UserUserTag::class)->addTagToUser($userTag, $this);
    }

    public function removeTag(\BristolSU\ControlDB\Contracts\Models\Tags\UserTag $userTag): void
    {
        app(UserUserTag::class)->removeTagFromUser($userTag, $this);
    }

    public function addRole(Role $role): void
    {
        app(UserRole::class)->addUserToRole($this, $role);
    }

    public function removeRole(Role $role): void
    {
        app(UserRole::class)->removeUserFromRole($this, $role);
    }

    public function addGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): void
    {
        app(UserGroup::class)->addUserToGroup($this, $group);
    }

    public function removeGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): void
    {
        app(UserGroup::class)->removeUserFromGroup($this, $group);
    }
    
    
}