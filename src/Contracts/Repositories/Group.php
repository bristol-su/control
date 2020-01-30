<?php

namespace BristolSU\ControlDB\Contracts\Repositories;

use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use Illuminate\Support\Collection;

/**
 * Handles groups
 */
interface Group
{

    /**
     * Get a group by ID
     *
     * @param int $id ID of the group
     * @return GroupModel
     */
    public function getById(int $id): GroupModel;

    /**
     * Get a group by its data provider ID
     * 
     * @param int $dataProviderId
     * @return GroupModel
     */
    public function getByDataProviderId(int $dataProviderId): GroupModel;

    /**
     * Get all groups
     *
     * @return Collection|GroupModel[]
     */
    public function all(): Collection;

    /**
     * Create a new group
     * 
     * @param int $dataProviderId
     * @return GroupModel
     */
    public function create(int $dataProviderId): GroupModel;

    /**
     * Delete a group by ID
     * 
     * @param int $id
     */
    public function delete(int $id): void;

}
