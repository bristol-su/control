<?php

namespace BristolSU\ControlDB\Contracts\Models;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Represents a group
 */
interface Group extends Arrayable, Jsonable
{

    /**
     * ID of the group
     *
     * @return int
     */
    public function id(): int;

    /**
     * Get the ID of the data provider
     * 
     * @return int
     */
    public function dataProviderId(): int;

    /**
     * Set the data provider ID
     *
     * @param int $dataProviderId
     */
    public function setDataProviderId(int $dataProviderId): void;

    /**
     * Get the DataGroup attached to the group
     *
     * @return DataGroup
     */
    public function data(): DataGroup;

    /**
     * Members of the group
     *
     * @return Collection
     */
    public function members(): Collection;

    /**
     * Roles belonging to the group
     *
     * @return Collection
     */
    public function roles(): Collection;

    /**
     * Tags the group is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection;

    /**
     * Add a group tag to the group
     * 
     * @param GroupTag $groupTag
     */
    public function addTag(GroupTag $groupTag): void;

    /**
     * Remove a group tag from the group
     * 
     * @param GroupTag $groupTag
     */
    public function removeTag(GroupTag $groupTag): void;

    /**
     * Add a user to the group
     * 
     * @param User $user
     */
    public function addUser(User $user): void;

    /**
     * Remove a user from the group
     * 
     * @param User $user
     */
    public function removeUser(User $user): void;



}
