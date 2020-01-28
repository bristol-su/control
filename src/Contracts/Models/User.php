<?php


namespace BristolSU\ControlDB\Contracts\Models;


use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Interface User
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface User extends Arrayable, Jsonable
{

    /**
     * ID of the user
     *
     * @return mixed
     */
    public function id(): int;

    // TODO Abstract!
    public function data(): DataUser;

    public function dataProviderId(): int;

    /**
     * Tags the user is tagged with
     *
     * @return Collection
     */
    // TODO Abstract!
    public function tags(): Collection;

    /**
     * Roles the user owns
     *
     * @return Collection
     */
    // TODO Abstract!
    public function roles(): Collection;

    /**
     * Groups the user is a member of
     *
     * @return Collection
     */
    // TODO Abstract!
    public function groups(): Collection;

    public function setDataProviderId(int $dataProviderId): void;

    // TODO Abstract!
    public function addTag(UserTag $userTag): void;

    // TODO Abstract!
    public function removeTag(UserTag $userTag): void;

    // TODO Abstract!
    public function addRole(Role $role): void;

    // TODO Abstract!
    public function removeRole(Role $role): void;

    // TODO Abstract!
    public function addGroup(Group $group): void;

    // TODO Abstract!
    public function removeGroup(Group $group): void;

}
