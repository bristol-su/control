<?php


namespace BristolSU\ControlDB\Repositories;


use BristolSU\ControlDB\Contracts\Models\User as UserModelContract;
use BristolSU\ControlDB\Contracts\Repositories\User as UserContract;
use Illuminate\Support\Collection;

/**
 * Class User
 * @package BristolSU\ControlDB\Repositories
 */
class User implements UserContract
{


    /**
     * @inheritDoc
     */
    public function getById(int $id): UserModelContract
    {
        return \BristolSU\ControlDB\Models\User::where('id', $id)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\User::all();
    }

    /**
     * @inheritDoc
     */
    public function create(int $dataProviderId): UserModelContract
    {
        return \BristolSU\ControlDB\Models\User::create([
            'data_provider_id' => $dataProviderId
        ]);
    }

    public function getByDataProviderId(int $dataProviderId): UserModelContract
    {
        return \BristolSU\ControlDB\Models\User::where('data_provider_id', $dataProviderId)->firstOrFail();
    }

    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }
}
