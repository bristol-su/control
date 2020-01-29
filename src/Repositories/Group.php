<?php

namespace BristolSU\ControlDB\Repositories;

use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupContract;
use Illuminate\Support\Collection;

/**
 * Class Group
 * @package BristolSU\ControlDB\Repositories
 */
class Group implements GroupContract
{

    /**
     * @inheritDoc
     */
    public function getById(int $id): GroupModel
    {
        return \BristolSU\ControlDB\Models\Group::where('id', $id)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Group::all();
    }

    public function create(int $dataProviderId): GroupModel
    {
        return \BristolSU\ControlDB\Models\Group::create([
            'data_provider_id' => $dataProviderId
        ]);
    }

    public function delete(int $id): void
    {
        \BristolSU\ControlDB\Models\Group::findOrFail($id)->delete();
    }

    public function getByDataProviderId(int $dataProviderId): GroupModel {
        return \BristolSU\ControlDB\Models\Group::where('data_provider_id', $dataProviderId)->firstOrFail();
    }

}
