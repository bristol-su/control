<?php

namespace BristolSU\ControlDB\Events\Role;

use BristolSU\ControlDB\Contracts\Models\Role;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The role instance.
     *
     * @var Role
     */
    public Role $role;

    /**
     * Create a new event instance.
     *
     * @param  Role  $role
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

}
