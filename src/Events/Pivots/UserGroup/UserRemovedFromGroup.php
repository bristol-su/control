<?php

namespace BristolSU\ControlDB\Events\Pivots\UserGroup;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRemovedFromGroup
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    public Group $group;

    public function __construct(User $user, Group $group)
    {
        $this->user = $user;
        $this->group = $group;
    }

}
