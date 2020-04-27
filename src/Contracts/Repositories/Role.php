<?php


namespace BristolSU\ControlDB\Contracts\Repositories;


use BristolSU\ControlDB\Contracts\Models\Role as RoleModel;
use Illuminate\Support\Collection;

/**
 * Interface Role
 */
interface Role
{

    /**
     * Get a role by ID
     *
     * @param int $id
     * @return RoleModel
     */
    public function getById(int $id): RoleModel;

    /**
     * Get all roles
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Role[]
     */
    public function all(): Collection;

    /**
     * Get a role by data provider ID
     * 
     * @param int $dataProviderId
     * @return RoleModel
     */
    public function getByDataProviderId(int $dataProviderId): RoleModel;

    /**
     * Create a new role
     * 
     * @param int $positionId
     * @param int $groupId
     * @param int $dataProviderId
     * @return RoleModel
     */
    public function create(int $positionId, int $groupId, int $dataProviderId): RoleModel;

    /**
     * Delete a role
     * 
     * @param int $id
     */
    public function delete(int $id): void;

    /**
     * Update the role model
     *
     * @param int $id
     * @param int $positionId
     * @param int $groupId
     * @param int $dataProviderId New data provider ID
     * @return RoleModel
     */
    public function update(int $id, int $positionId, int $groupId, int $dataProviderId): RoleModel;
    
    /**
     * Get all roles that belong to the given group
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Group $group
     * @return Collection|RoleModel[]
     */
    public function allThroughGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): Collection;

    /**
     * Get all roles that belong to the given position
     * @param \BristolSU\ControlDB\Contracts\Models\Position $position
     * @return Collection|RoleModel[]
     */
    public function allThroughPosition(\BristolSU\ControlDB\Contracts\Models\Position $position): Collection;

    /**
     * Paginate through all the roles
     *
     * @param int $page The page number to return
     * @param int $perPage The number of results to return per page
     *
     * @return Collection|RoleModel[]
     */
    public function paginate(int $page, int $perPage): Collection;

    /**
     * Get the number of roles
     *
     * @return int
     */
    public function count(): int;
    
}
