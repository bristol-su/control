<?php


namespace BristolSU\ControlDB\Contracts\Models;


use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

/**
 * Interface Role
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface Role extends Authenticatable
{

    /**
     * ID of the position
     *
     * @return mixed
     */
    public function positionId();

    // TODO Abstract!
    public function data(): DataRole;

    public function dataProviderId();
    
    /**
     * ID of the group
     *
     * @return mixed
     */
    public function groupId();

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
    // TODO Abstract!
    public function users(): Collection;

    /**
     * Tags the role is tagged with
     *
     * @return Collection
     */
    // TODO Abstract!
    public function tags(): Collection;

    /**
     * Get the ID of the role
     *
     * @return int
     */
    public function id(): int;

    public function setGroupId(int $groupId);
    
    public function setPositionId(int $positionId);

    public function setDataProviderId(int $dataProviderId);

    // TODO Abstract!
    public function addTag(RoleTag $roleTag);

    // TODO Abstract!
    public function removeTag(RoleTag $roleTag);


    // TODO Abstract!
    public function addUser(User $user);

    // TODO Abstract!
    public function removeUser(User $user);
}
