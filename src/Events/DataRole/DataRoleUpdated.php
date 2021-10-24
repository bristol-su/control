<?php

namespace BristolSU\ControlDB\Events\DataRole;

use BristolSU\ControlDB\Contracts\Models\DataRole;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataRoleUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The data role instance.
     *
     * @var DataRole
     */
    public DataRole $dataRole;
    public array $updatedData;

    /**
     * Create a new event instance.
     *
     * @param  DataRole  $dataRole
     * @return void
     */
    public function __construct(DataRole $dataRole, array $updatedData)
    {
        $this->dataRole = $dataRole;
        $this->updatedData = $updatedData;
    }

}
