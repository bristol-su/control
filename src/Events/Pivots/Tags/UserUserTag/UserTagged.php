<?php

namespace BristolSU\ControlDB\Events\Pivots\Tags\UserUserTag;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserTagged
{
    use Dispatchable, SerializesModels;

    public User $user;
    public UserTag $userTag;

    public function __construct(User $user, UserTag $userTag)
    {
        $this->user = $user;
        $this->userTag = $userTag;
    }

}
