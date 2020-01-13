<?php


namespace BristolSU\ControlDB\Contracts\Models;


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

    public function email(): ?string;

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
     * Custom name of the position.
     *
     * This does not need to be the same as the actual position name. It may instead be anything you like, to allow for
     * more granular control over the positions and roles owned by an individual, whilst not creating too many positions.
     *
     * @return string
     */
    // TODO Check this works fine
    public function positionName(): string;

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

}
