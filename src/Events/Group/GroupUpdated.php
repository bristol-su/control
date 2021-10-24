<?php

namespace BristolSU\ControlDB\Events\Group;

use BristolSU\ControlDB\Contracts\Models\Group;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GroupUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The group instance.
     *
     * @var Group
     */
    public Group $group;
    public array $updatedData;

    /**
     * Create a new event instance.
     *
     * @param  Group  $group
     * @return void
     */
    public function __construct(Group $group, array $updatedData)
    {
        $this->group = $group;
        $this->updatedData = $updatedData;
    }

}
