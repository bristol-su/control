<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

use BristolSU\ControlDB\Contracts\Models\Position as PositionModel;
use Illuminate\Support\Collection;

/**
 * Handles positions
 */
interface Position
{
    /**
     * Get a position by ID
     *
     * @param int $id ID of the position
     * @return PositionModel
     */
    public function getById(int $id): PositionModel;

    /**
     * Get a position by its data provider ID
     *
     * @param int $dataProviderId
     * @return PositionModel
     */
    public function getByDataProviderId(int $dataProviderId): PositionModel;

    /**
     * Get all positions
     *
     * @return Collection|PositionModel[]
     */
    public function all(): Collection;

    /**
     * Create a new position
     *
     * @param int $dataProviderId
     * @return PositionModel
     */
    public function create(int $dataProviderId): PositionModel;

    /**
     * Update the position model
     *
     * @param int $id
     * @param int $dataProviderId New data provider ID
     * @return PositionModel
     */
    public function update(int $id, int $dataProviderId): PositionModel;
    
    /**
     * Delete a position by ID
     *
     * @param int $id
     */
    public function delete(int $id): void;

    /**
     * Paginate through all the positions
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|PositionModel[]
     */
    public function paginate(int $page, int $perPage): Collection;

    /**
     * Get the number of positions
     *
     * @return int
     */
    public function count(): int;
}