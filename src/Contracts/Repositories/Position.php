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
     * Delete a position by ID
     *
     * @param int $id
     */
    public function delete(int $id): void;
}
