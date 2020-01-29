<?php


namespace BristolSU\ControlDB\Repositories;



use BristolSU\ControlDB\Contracts\Repositories\Role as RoleContract;
use Illuminate\Support\Collection;

/**
 * Class Role
 * @package BristolSU\ControlDB\Repositories
 */
class Role implements RoleContract
{


    /**
     * @inheritDoc
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Role
    {
        return \BristolSU\ControlDB\Models\Role::where('id', $id)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Role::all();
    }

    public function create(int $positionId, int $groupId, int $dataProviderId): \BristolSU\ControlDB\Contracts\Models\Role
    {
        return \BristolSU\ControlDB\Models\Role::create([
            'position_id' => $positionId,
            'group_id' => $groupId,
            'data_provider_id' => $dataProviderId
        ]);
    }

    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }

    public function getByDataProviderId(int $dataProviderId): \BristolSU\ControlDB\Contracts\Models\Role {
        return \BristolSU\ControlDB\Models\Role::where('data_provider_id', $dataProviderId)->firstOrFail();
    }

    public function allThroughGroup(\BristolSU\ControlDB\Contracts\Models\Group $group): Collection
    {
        return \BristolSU\ControlDB\Models\Role::where('group_id', $group->id())->get();
    }

    public function allThroughPosition(\BristolSU\ControlDB\Contracts\Models\Position $position): Collection
    {
        return \BristolSU\ControlDB\Models\Role::where('position_id', $position->id())->get();
    }
}
