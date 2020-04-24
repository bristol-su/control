<?php

namespace BristolSU\ControlDB\Traits;

use BristolSU\ControlDB\Contracts\Models\DataGroup;
use BristolSU\ControlDB\Contracts\Repositories\Group;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use Illuminate\Support\Collection;

/**
 * Implements common methods using repositories required by the group model interface
 */
trait GroupTrait
{

    /**
     * Get the data group for this group
     * 
     * @return DataGroup
     */
    public function data(): DataGroup
    {
        return app(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class)->getById($this->dataProviderId());
    }

    /**
     * Set the ID of the data provider
     *
     * @param int $dataProviderId
     */
    public function setDataProviderId(int $dataProviderId): void
    {
        app(Group::class)->update($this->id(), $dataProviderId);
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

    /**
     * Add a tag to the group
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag $groupTag
     */
    public function addTag(\BristolSU\ControlDB\Contracts\Models\Tags\GroupTag $groupTag): void
    {
        app(GroupGroupTag::class)->addTagToGroup($groupTag, $this);
    }

    /**
     * Remove a tag from the group
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag $groupTag
     */
    public function removeTag(\BristolSU\ControlDB\Contracts\Models\Tags\GroupTag $groupTag): void
    {
        app(GroupGroupTag::class)->removeTagFromGroup($groupTag, $this);
    }

    /**
     * Add a user to the group
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\User $user
     */
    public function addUser(\BristolSU\ControlDB\Contracts\Models\User $user): void
    {
        app(UserGroup::class)->addUserToGroup($user, $this);

    }

    /**
     * Remove a user from the group
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\User $user
     */
    public function removeUser(\BristolSU\ControlDB\Contracts\Models\User $user): void
    {
        app(UserGroup::class)->removeUserFromGroup($user, $this);
    }


}