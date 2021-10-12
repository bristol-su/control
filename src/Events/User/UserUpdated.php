<?php

namespace BristolSU\ControlDB\Events\User;

use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user instance.
     *
     * @var User
     */
    public User $user;
    private array $updatedData;

    /**
     * Create a new event instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct(User $user, array $updatedData)
    {
        $this->user = $user;
        $this->updatedData = $updatedData;
    }

}
