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
    public function getById($id): \BristolSU\ControlDB\Contracts\Models\Role
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

    public function create($positionId, $groupId, $dataProviderId): \BristolSU\ControlDB\Contracts\Models\Role
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

    public function getByDataProviderId($dataProviderId): \BristolSU\ControlDB\Contracts\Models\Role {
        return \BristolSU\ControlDB\Models\Role::where('data_provider_id', $dataProviderId)->firstOrFail();
    }
}
