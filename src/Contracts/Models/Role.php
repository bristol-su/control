<?php


namespace BristolSU\ControlDB\Contracts\Models;


use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Represents a role
 */
interface Role extends Arrayable, Jsonable
{

    /**
     * Get the ID of the role
     *
     * @return int
     */
    public function id(): int;

    /**
     * ID of the position the role belongs to
     *
     * @return mixed
     */
    public function positionId(): int;

    /**
     * ID of the role data provider
     * 
     * @return int
     */
    public function dataProviderId(): int;

    /**
     * ID of the group
     *
     * @return mixed
     */
    public function groupId(): int;

    /**
     * Set the ID of the group the role belongs to
     * 
     * @param int $groupId
     */
    public function setGroupId(int $groupId): void;

    /**
     * Set the ID of the position the group belongs to
     * 
     * @param int $positionId
     */
    public function setPositionId(int $positionId): void;

    /**
     * Set the ID of the data provider
     * 
     * @param int $dataProviderId
     */
    public function setDataProviderId(int $dataProviderId): void;

    /**
     * Data associated with the role
     *
     * @return DataRole
     */
    public function data(): DataRole;
    /**
     * Position belonging to the role
     *
     * @return Position
     */
    public function position(): Position;

    /**
     * Group belonging to the role
     *
     * @return Group
     */
    public function group(): Group;

    /**
     * Users who occupy the role
     *
     * @return Collection
     */
    public function users(): Collection;

    /**
     * Tags the role is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection;

    /**
     * Add a tag to the role
     * 
     * @param RoleTag $roleTag
     */
    public function addTag(RoleTag $roleTag): void;

    /**
     * Remove a tag from the role
     * 
     * @param RoleTag $roleTag
     */
    public function removeTag(RoleTag $roleTag): void;

    /**
     * Add a user to the role
     * 
     * @param User $user
     */
    public function addUser(User $user): void;

    /**
     * Remove a user from the role
     * 
     * @param User $user
     */
    public function removeUser(User $user): void;
}
