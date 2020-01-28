<?php


namespace BristolSU\ControlDB\Repositories;


use BristolSU\ControlDB\Models\Position as PositionModel;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionContract;
use Illuminate\Support\Collection;

/**
 * Class Position
 */
class Position implements PositionContract
{


    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Position::all();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Position
    {
        return \BristolSU\ControlDB\Models\Position::where('id', $id)->firstOrFail();
    }

    public function getByDataProviderId($dataProviderId): \BristolSU\ControlDB\Contracts\Models\Position {
        return \BristolSU\ControlDB\Models\Position::where('data_provider_id', $dataProviderId)->firstOrFail();
    }


    public function create(int $dataProviderId): \BristolSU\ControlDB\Contracts\Models\Position
    {
        return \BristolSU\ControlDB\Models\Position::create(['data_provider_id' => $dataProviderId]);
    }

    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }
}
