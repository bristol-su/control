<?php

namespace BristolSU\Control\Events\Pivots\UserRole;

use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRemovedFromRole
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    public Role $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

}
