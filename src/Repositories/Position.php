<?php


namespace BristolSU\ControlDB\Repositories;


use BristolSU\ControlDB\Models\Position as PositionModel;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionContract;
use Illuminate\Support\Collection;

/**
 * Class Position
 * @package BristolSU\ControlDB\Repositories
 */
class Position extends PositionContract
{


    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Position::all();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Position
    {
        return \BristolSU\ControlDB\Models\Position::where('id', $id)->firstOrFail();
    }
}
