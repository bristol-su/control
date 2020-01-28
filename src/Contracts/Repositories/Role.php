<?php


namespace BristolSU\ControlDB\Contracts\Repositories;


use BristolSU\ControlDB\Contracts\Models\Role as RoleModel;
use Illuminate\Support\Collection;

/**
 * Interface Role
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
interface Role
{

    /**
     * Get a role by ID
     *
     * @param $id
     * @return RoleModel
     */
    public function getById($id): RoleModel;

    /**
     * Get all roles
     *
     * @return Collection
     */
    public function all(): Collection;

    public function getByDataProviderId($dataProviderId): RoleModel;


    public function create($positionId, $groupId, $dataProviderId): RoleModel;
    
    public function delete(int $id): void;

    public function allThroughGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): Collection;

    public function allThroughPosition(\BristolSU\ControlDB\Contracts\Models\Position $position): Collection;
    
}
