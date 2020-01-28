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

    /**
     * ID of the data provider for the user
     * 
     * @return int
     */
    public function dataProviderId(): int;

    /**
     * Set data provider of the user
     * 
     * @param int $dataProviderId
     */
    public function setDataProviderId(int $dataProviderId): void;

    /**
     * Get the data attributes for the user
     * 
     * @return DataUser
     */
    public function data(): DataUser;

    /**
     * Tags the user is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection;

    /**
     * Roles the user owns
     *
     * @return Collection
     */
    public function roles(): Collection;

    /**
     * Groups the user is a member of
     *
     * @return Collection
     */
    public function groups(): Collection;

    /**
     * Add a tag to the user
     * 
     * @param UserTag $userTag
     */
    public function addTag(UserTag $userTag): void;

    /**
     * Remove a tag from the user
     * 
     * @param UserTag $userTag
     */
    public function removeTag(UserTag $userTag): void;

    /**
     * Add a role to the user
     * 
     * @param Role $role
     */
    public function addRole(Role $role): void;

    /**
     * Remove a role from the user
     * 
     * @param Role $role
     */
    public function removeRole(Role $role): void;

    /**
     * Add a group from the user
     * 
     * @param Group $group
     */
    public function addGroup(Group $group): void;

    /**
     * Remove a group from the user
     * 
     * @param Group $group
     */
    public function removeGroup(Group $group): void;

}
