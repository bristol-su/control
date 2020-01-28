<?php


namespace BristolSU\ControlDB\Contracts\Models;


use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Interface Role
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface Role extends Arrayable, Jsonable
{

    /**
     * ID of the position
     *
     * @return mixed
     */
    public function positionId(): int;

    public function data(): DataRole;

    public function dataProviderId(): int;
    
    /**
     * ID of the group
     *
     * @return mixed
     */
    public function groupId(): int;

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
     * Get the ID of the role
     *
     * @return int
     */
    public function id(): int;

    public function setGroupId(int $groupId): void;
    
    public function setPositionId(int $positionId): void;

    public function setDataProviderId(int $dataProviderId): void;

    public function addTag(RoleTag $roleTag): void;

    public function removeTag(RoleTag $roleTag): void;


    public function addUser(User $user): void;

    public function removeUser(User $user): void;
}
