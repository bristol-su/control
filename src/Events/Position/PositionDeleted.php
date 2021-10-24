<?php

namespace BristolSU\ControlDB\Events\Position;

use BristolSU\ControlDB\Contracts\Models\Position;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PositionDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The position instance.
     *
     * @var Position
     */
    public Position $position;

    /**
     * Create a new event instance.
     *
     * @param  Position  $position
     * @return void
     */
    public function __construct(Position $position)
    {
        $this->position = $position;
    }

}
