<?php


namespace BristolSU\ControlDB\Http\Controllers\User;


use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;

/**
 * Handles the linking of users and groups
 */
class UserGroupController extends Controller
{

    /**
     * Get all groups that belong to a user
     * 
     * @param User $user
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(User $user)
    {
        return $this->paginate($user->groups());
    }

    /**
     * Add a group to a user
     * 
     * @param User $user
     * @param Group $group
     */
    public function update(User $user, Group $group)
    {
        $user->addGroup($group);
    }

    /**
     * Remove a group from a user
     * 
     * @param User $user
     * @param Group $group
     */
    public function destroy(User $user, Group $group)
    {
        $user->removeGroup($group);
    }

}
