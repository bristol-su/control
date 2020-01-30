<?php

namespace BristolSU\ControlDB\Repositories;

use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupContract;
use Illuminate\Support\Collection;

/**
 * Handles groups
 */
class Group implements GroupContract
{

    /**
     * Get a group by ID
     *
     * @param int $id ID of the group
     * @return GroupModel
     */
    public function getById(int $id): GroupModel
    {
        return \BristolSU\ControlDB\Models\Group::where('id', $id)->firstOrFail();
    }

    /**
     * Get all groups
     *
     * @return Collection|GroupModel[]
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Group::all();
    }

    /**
     * Create a new group
     *
     * @param int $dataProviderId
     * @return GroupModel
     */
    public function create(int $dataProviderId): GroupModel
    {
        return \BristolSU\ControlDB\Models\Group::create([
            'data_provider_id' => $dataProviderId
        ]);
    }

    /**
     * Delete a group by ID
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        \BristolSU\ControlDB\Models\Group::findOrFail($id)->delete();
    }

    /**
     * Get a group by its data provider ID
     *
     * @param int $dataProviderId
     * @return GroupModel
     */
    public function getByDataProviderId(int $dataProviderId): GroupModel {
        return \BristolSU\ControlDB\Models\Group::where('data_provider_id', $dataProviderId)->firstOrFail();
    }

}
