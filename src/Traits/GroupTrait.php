<?php

namespace BristolSU\ControlDB\Traits;

use BristolSU\ControlDB\Contracts\Models\DataGroup;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use Illuminate\Support\Collection;

trait GroupTrait
{

    public function data(): DataGroup
    {
        return app(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class)->getById($this->dataProviderId());
    }

    /**
     * Members of the group
     *
     * @return Collection
     */
    public function members(): Collection
    {
        return app(UserGroup::class)->getUsersThroughGroup($this);
    }

    /**
     * Roles belonging to the group
     *
     * @return Collection
     */
    public function roles(): Collection
    {
        return app(Role::class)->allThroughGroup($this);
    }

    /**
     * Tags the group is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return app(GroupGroupTag::class)->getTagsThroughGroup($this);
    }

    public function addTag(\BristolSU\ControlDB\Contracts\Models\Tags\GroupTag $groupTag): void
    {
        app(GroupGroupTag::class)->addTagToGroup($groupTag, $this);
    }

    public function removeTag(\BristolSU\ControlDB\Contracts\Models\Tags\GroupTag $groupTag): void
    {
        app(GroupGroupTag::class)->removeTagFromGroup($groupTag, $this);
    }

    public function addUser(\BristolSU\ControlDB\Contracts\Models\User $user): void
    {
        app(UserGroup::class)->addUserToGroup($user, $this);

    }

    public function removeUser(\BristolSU\ControlDB\Contracts\Models\User $user): void
    {
        app(UserGroup::class)->removeUserFromGroup($user, $this);
    }


}