<?php


namespace BristolSU\ControlDB\Repositories;



use BristolSU\ControlDB\Contracts\Models\Role as RoleModel;
use BristolSU\ControlDB\Contracts\Repositories\Role as RoleContract;
use Illuminate\Support\Collection;

/**
 * Class Role
 */
class Role implements RoleContract
{


    /**
     * Get a role by ID
     *
     * @param int $id
     * @return RoleModel
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Role
    {
        return \BristolSU\ControlDB\Models\Role::where('id', $id)->firstOrFail();
    }

    /**
     * Get all roles
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Role[]
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Role::all();
    }

    /**
     * Create a new role
     *
     * @param int $positionId
     * @param int $groupId
     * @param int $dataProviderId
     * @return RoleModel
     */
    public function create(int $positionId, int $groupId, int $dataProviderId): \BristolSU\ControlDB\Contracts\Models\Role
    {
        return \BristolSU\ControlDB\Models\Role::create([
            'position_id' => $positionId,
            'group_id' => $groupId,
            'data_provider_id' => $dataProviderId
        ]);
    }

    /**
     * Delete a role
     *
     * @param int $id
     */
    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }

    /**
     * Get a role by data provider ID
     *
     * @param int $dataProviderId
     * @return RoleModel
     */
    public function getByDataProviderId(int $dataProviderId): \BristolSU\ControlDB\Contracts\Models\Role {
        return \BristolSU\ControlDB\Models\Role::where('data_provider_id', $dataProviderId)->firstOrFail();
    }
    
    /**
     * Get all roles that belong to the given group
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Group $group
     * @return Collection|RoleModel[]
     */
    public function allThroughGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): Collection
    {
        return \BristolSU\ControlDB\Models\Role::where('group_id', $group->id())->get();
    }

    /**
     * Get all roles that belong to the given position
     * @param \BristolSU\ControlDB\Contracts\Models\Position $position
     * @return Collection|RoleModel[]
     */
    public function allThroughPosition(\BristolSU\ControlDB\Contracts\Models\Position $position): Collection
    {
        return \BristolSU\ControlDB\Models\Role::where('position_id', $position->id())->get();
    }
}
