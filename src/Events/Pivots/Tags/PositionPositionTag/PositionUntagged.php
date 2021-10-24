<?php

namespace BristolSU\ControlDB\Events\Pivots\Tags\PositionPositionTag;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Models\Position;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PositionUntagged
{
    use Dispatchable, SerializesModels;

    public Position $position;
    public PositionTag $positionTag;

    public function __construct(Position $position, PositionTag $positionTag)
    {
        $this->position = $position;
        $this->positionTag = $positionTag;
    }

}
