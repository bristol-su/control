<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\User;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Models\User;

class UserUserTagController extends Controller
{

    public function index(User $user)
    {
        return $user->tags();
    }

    public function update(User $user, UserTag $userTag)
    {
        return $user->addTag($userTag);
    }

    public function destroy(User $user, UserTag $userTag)
    {
        $user->removeTag($userTag);
    }

}
