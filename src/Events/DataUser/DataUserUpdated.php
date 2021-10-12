<?php

namespace BristolSU\ControlDB\Events\DataUser;

use BristolSU\ControlDB\Contracts\Models\DataUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DataUserUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The data user instance.
     *
     * @var DataUser
     */
    public DataUser $dataUser;
    private array $updatedData;

    /**
     * Create a new event instance.
     *
     * @param  DataUser  $dataUser
     * @return void
     */
    public function __construct(DataUser $dataUser, array $updatedData)
    {
        $this->dataUser = $dataUser;
        $this->updatedData = $updatedData;
    }

}
