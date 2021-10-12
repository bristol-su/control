<?php

namespace BristolSU\ControlDB\Events\DataRole;

use BristolSU\ControlDB\Contracts\Models\DataRole;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataRoleCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The data role instance.
     *
     * @var DataRole
     */
    public DataRole $dataRole;

    /**
     * Create a new event instance.
     *
     * @param  DataRole  $dataRole
     * @return void
     */
    public function __construct(DataRole $dataRole)
    {
        $this->dataRole = $dataRole;
    }

}
