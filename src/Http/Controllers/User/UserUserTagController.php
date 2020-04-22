<?php

namespace BristolSU\ControlDB\Http\Controllers\User;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;

/**
 * Handle the tagging and untagging of users
 */
class UserUserTagController extends Controller
{

    /**
     * Get all tags belonging to the current user
     *
     * @param User $user
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function index(User $user)
    {
        return $this->paginate($user->tags());
        
    }

    /**
     * Tag a user
     *
     * @param User $user
     * @param UserTag $userTag
     */
    public function update(User $user, UserTag $userTag)
    {
        $user->addTag($userTag);
    }

    /**
     * Untag user
     *
     * @param User $user
     * @param UserTag $userTag
     */
    public function destroy(User $user, UserTag $userTag)
    {
        $user->removeTag($userTag);
    }

}
