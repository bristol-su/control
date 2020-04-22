<?php

namespace BristolSU\ControlDB\Http\Controllers\UserTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Models\User;

/**
 * Handle the link between a user tag and a user
 */
class UserTagUserController extends Controller
{
    /**
     * Get all users with the given tag
     * 
     * @param UserTag $userTag
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(UserTag $userTag)
    {
        return $this->paginate($userTag->users());
    }

    /**
     * Add the user to the tag
     * 
     * @param UserTag $userTag
     * @param User $user
     */
    public function update(UserTag $userTag, User $user)
    {
        $userTag->addUser($user);
    }

    /**
     * Remove the user from the tag
     * 
     * @param UserTag $userTag
     * @param User $user
     */
    public function destroy(UserTag $userTag, User $user)
    {
        $userTag->removeUser($user);
    }

}
