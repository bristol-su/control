<?php

namespace BristolSU\ControlDB\Events\DataPosition;

use BristolSU\ControlDB\Contracts\Models\DataPosition;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataPositionCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The data position instance.
     *
     * @var DataPosition
     */
    public DataPosition $dataPosition;

    /**
     * Create a new event instance.
     *
     * @param  DataPosition  $dataPosition
     * @return void
     */
    public function __construct(DataPosition $dataPosition)
    {
        $this->dataPosition = $dataPosition;
    }

}
