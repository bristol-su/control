<?php

namespace BristolSU\ControlDB\Http\Controllers\Group;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;

/**
 * Handles the link between a group and a user
 */
class GroupUserController extends Controller
{

    /**
     * Get all users from a group
     * 
     * @param Group $group
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(Group $group)
    {
        return $this->paginate($group->members());
    }

    /**
     * Add a user to a group
     * 
     * @param Group $group
     * @param User $user
     */
    public function update(Group $group, User $user)
    {
        $group->addUser($user);
    }

    /**
     * Remove a user from a group
     * 
     * @param Group $group
     * @param User $user
     */
    public function destroy(Group $group, User $user)
    {
        $group->removeUser($user);
    }

}
