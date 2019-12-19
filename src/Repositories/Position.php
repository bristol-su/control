<?php


namespace BristolSU\ControlDB\Repositories;


use BristolSU\ControlDB\Models\Position as PositionModel;
use BristolSU\Support\Control\Contracts\Repositories\Position as PositionContract;
use Illuminate\Support\Collection;

/**
 * Class Position
 * @package BristolSU\ControlDB\Repositories
 */
class Position extends PositionContract
{

    /**
     * Get all positions
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Position::all();
    }

    /**
     * Get a position by a given ID
     *
     * @param int $id
     * @return \BristolSU\Support\Control\Contracts\Models\Position
     */
    public function getById(int $id): \BristolSU\Support\Control\Contracts\Models\Position
    {
        return \BristolSU\ControlDB\Models\Position::findOrFail($id);
    }
}
