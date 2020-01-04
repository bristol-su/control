<?php


namespace BristolSU\ControlDB\Contracts\Repositories;


use BristolSU\ControlDB\Contracts\Models\Position as PositionModel;
use Illuminate\Support\Collection;

/**
 * Interface Position
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
abstract class Position
{
    /**
     * Get all positions
     * 
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get a position by a given ID
     * 
     * @param int $id
     * @return PositionModel
     */
    public function getById(int $id): PositionModel;
}
