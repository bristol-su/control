<?php


namespace BristolSU\ControlDB\Contracts\Repositories;


use BristolSU\ControlDB\Contracts\Models\Position as PositionModel;
use Illuminate\Support\Collection;

/**
 * Interface Position
 */
interface Position
{
    /**
     * Get all positions
     *
     * @return Collection
     */
    public function all(): Collection;

    public function getByDataProviderId($dataProviderId): PositionModel;

    /**
     * Get a position by a given ID
     *
     * @param int $id
     * @return PositionModel
     */
    public function getById(int $id): PositionModel;
    
    public function create(int $dataProviderId): PositionModel;

    public function delete(int $id): void;

}
