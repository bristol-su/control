<?php

namespace BristolSU\ControlDB\Contracts\Models;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Interface Group
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface Group extends Arrayable, Jsonable
{

    public function data(): DataGroup;

    public function dataProviderId(): int;

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

    public function addTag(GroupTag $groupTag): void;

    public function removeTag(GroupTag $groupTag): void;

    public function addUser(User $user): void;

    public function removeUser(User $user): void;

    public function setDataProviderId(int $dataProviderId): void;

}
