<?php

namespace BristolSU\ControlDB\Repositories;

use BristolSU\ControlDB\Contracts\Models\Position as PositionModel;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionContract;
use Illuminate\Support\Collection;

/**
 * Handles positions
 */
class Position implements PositionContract
{

    /**
     * Get a position by ID
     *
     * @param int $id ID of the position
     * @return PositionModel
     */
    public function getById(int $id): PositionModel
    {
        return \BristolSU\ControlDB\Models\Position::findOrFail($id);
    }

    /**
     * Get all positions
     *
     * @return Collection|PositionModel[]
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Position::all();
    }

    /**
     * Create a new position
     *
     * @param int $dataProviderId
     * @return PositionModel
     */
    public function create(int $dataProviderId): PositionModel
    {
        return \BristolSU\ControlDB\Models\Position::create([
            'data_provider_id' => $dataProviderId
        ]);
    }

    /**
     * Delete a position by ID
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        \BristolSU\ControlDB\Models\Position::findOrFail($id)->delete();
    }

    /**
     * Get a position by its data provider ID
     *
     * @param int $dataProviderId
     * @return PositionModel
     */
    public function getByDataProviderId(int $dataProviderId): PositionModel {
        return \BristolSU\ControlDB\Models\Position::where('data_provider_id', $dataProviderId)->firstOrFail();
    }

}
