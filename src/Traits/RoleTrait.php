<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\DataRole as DataRoleModel;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\DataRole as DataRoleRepository;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\RoleRoleTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\UserRole;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use Illuminate\Support\Collection;

trait RoleTrait
{

    public function data(): DataRoleModel
    {
        return app(DataRoleRepository::class)->getById($this->dataProviderId());
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

    public function addTag(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTag $roleTag): void
    {
        app(RoleRoleTag::class)->addTagToRole($roleTag, $this);
    }

    public function removeTag(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTag $roleTag): void
    {
        app(RoleRoleTag::class)->removeTagFromRole($roleTag, $this);
    }

    public function addUser(User $user): void
    {
        app(UserRole::class)->addUserToRole($user, $this);
    }

    public function removeUser(User $user): void
    {
        app(UserRole::class)->removeUserFromRole($user, $this);
    }

}