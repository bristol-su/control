<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\UserTag;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Models\User;

class UserTagUserController extends Controller
{

    public function index(UserTag $userTag)
    {
        return $userTag->users();
    }

    public function update(UserTag $userTag, User $user)
    {
        $userTag->addUser($user);
    }

    public function destroy(UserTag $userTag, User $user)
    {
        $userTag->removeUser($user);
    }

}
