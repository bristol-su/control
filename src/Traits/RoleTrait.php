<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\DataRole as DataRoleModel;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Contracts\Repositories\Role;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use Illuminate\Support\Collection;

/**
 * Implements common methods using repositories required by the role model interface
 */
trait RoleTrait
{

    /**
     * Get the data attributes of the role
     * 
     * @return DataRoleModel
     */
    public function data(): DataRoleModel
    {
        return app(DataRoleRepository::class)->getById($this->dataProviderId());
    }

    /**
     * Set the ID of the data provider
     *
     * @param int $dataProviderId
     */
    public function setDataProviderId(int $dataProviderId): void
    {
        app(Role::class)->update($this->id(), $this->positionId(), $this->groupId(), $dataProviderId);
    }

    /**
     * Set a group ID
     *
     * @param int $groupId
     */
    public function setGroupId(int $groupId): void
    {
        app(Role::class)->update($this->id(), $this->positionId(), $groupId, $this->dataProviderId());
    }

    /**
     * Set a position ID
     *
     * @param int $positionId
     */
    public function setPositionId(int $positionId): void
    {
        app(Role::class)->update($this->id(), $positionId, $this->groupId(), $this->dataProviderId());
    }

    /**
     * Position belonging to the role
     *
     * @return Position
     */
    public function position(): \BristolSU\ControlDB\Contracts\Models\Position
    {
        return app(\BristolSU\ControlDB\Contracts\Repositories\Position::class)->getById($this->positionId());
    }

    /**
     * Group belonging to the role
     *
     * @return Group
     */
    public function group(): \BristolSU\ControlDB\Contracts\Models\Group
    {
        return app(\BristolSU\ControlDB\Contracts\Repositories\Group::class)->getById($this->groupId());
    }

    /**
     * Users who occupy the role
     *
     * @return Collection
     */
    public function users(): Collection
    {
        return app(UserRole::class)->getUsersThroughRole($this);
    }

    /**
     * Tags the role is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return app(RoleRoleTag::class)->getTagsThroughRole($this);
    }

    /**
     * Add a tag to the role
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag $roleTag
     */
    public function addTag(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTag $roleTag): void
    {
        app(RoleRoleTag::class)->addTagToRole($roleTag, $this);
    }

    /**
     * Remove a tag from the role
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\RoleTag $roleTag
     */
    public function removeTag(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTag $roleTag): void
    {
        app(RoleRoleTag::class)->removeTagFromRole($roleTag, $this);
    }

    /**
     * Add a user to the role
     * 
     * @param User $user
     */
    public function addUser(User $user): void
    {
        app(UserRole::class)->addUserToRole($user, $this);
    }

    /**
     * Remove a user from the role
     * 
     * @param User $user
     */
    public function removeUser(User $user): void
    {
        app(UserRole::class)->removeUserFromRole($user, $this);
    }

}