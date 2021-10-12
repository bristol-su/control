<?php

namespace BristolSU\ControlDB\Events\DataGroup;

use BristolSU\ControlDB\Contracts\Models\DataGroup;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataGroupCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The data group instance.
     *
     * @var DataGroup
     */
    public DataGroup $dataGroup;

    /**
     * Create a new event instance.
     *
     * @param  DataGroup  $dataGroup
     * @return void
     */
    public function __construct(DataGroup $dataGroup)
    {
        $this->dataGroup = $dataGroup;
    }

}
