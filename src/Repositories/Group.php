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
        return \BristolSU\ControlDB\Models\Group::findOrFail($id);
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

    /**
     * Paginate through all the groups
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|GroupModel[]
     */
    public function paginate(int $page, int $perPage): Collection
    {
        return \BristolSU\ControlDB\Models\Group::paginate($perPage, ['*'], 'page', $page)->getCollection();
    }

    /**
     * Get the number of groups
     *
     * @return int
     */
    public function count(): int
    {
        return \BristolSU\ControlDB\Models\Group::count();
    }

}
