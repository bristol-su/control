<?php

namespace BristolSU\ControlDB\Contracts\Models;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

/**
 * Interface Group
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface Group extends Authenticatable
{

    /**
     * Name of the group
     *
     * @return string
     */
    public function name(): string;


    public function data(): DataGroup;

    public function dataProviderId();
    
    /**
     * Contact email address for the group
     *
     * @return string|null
     */
    public function email(): ?string;

    /**
     * ID of the group
     *
     * @return int
     */
    public function id(): int;

    /**
     * Members of the group
     *
     * @return Collection
     */
    // TODO Abstract!
    public function members(): Collection;

    /**
     * Roles belonging to the group
     *
     * @return Collection
     */
    // TODO Abstract!
    public function roles(): Collection;

    /**
     * Tags the group is tagged with
     *
     * @return Collection
     */
    // TODO Abstract!
    public function tags(): Collection;

    // TODO Abstract!
    public function addTag(GroupTag $groupTag);

    // TODO Abstract!
    public function removeTag(GroupTag $groupTag);

    // TODO Abstract!
    public function addUser(User $user);

    // TODO Abstract!
    public function removeUser(User $user);

    public function setDataProviderId(int $dataProviderId);

}
