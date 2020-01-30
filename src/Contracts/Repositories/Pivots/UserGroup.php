<?php

namespace BristolSU\ControlDB\Contracts\Repositories\Pivots;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Support\Collection;

/**
 * Handles the membership of users to group
 */
interface UserGroup
{

    /**
     * Get all users who are members of a group
     * 
     * @param Group $group 
     * @return User[]|Collection Users who are members of the group
     */
    public function getUsersThroughGroup(Group $group): Collection;

    /**
     * Get all groups a user belongs to
     * 
     * @param User $user
     * @return Group[]|Collection Groups the user is a member of
     */
    public function getGroupsThroughUser(User $user): Collection;

    /**
     * Add a user to a group
     * 
     * @param User $user User to add to the group
     * @param Group $group Group to add the user to
     * @return void 
     */
    public function addUserToGroup(User $user, Group $group): void;

    /**
     * Remove a user from a group
     * @param User $user User to remove from the group
     * @param Group $group Group to remove the user from
     * @return void 
     */
    public function removeUserFromGroup(User $user, Group $group): void;
}