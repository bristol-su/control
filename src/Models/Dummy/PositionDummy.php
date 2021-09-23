<?php

namespace BristolSU\ControlDB\Models\Dummy;

use BristolSU\ControlDB\Contracts\Models\DataPosition;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class PositionDummy implements Position
{

    private ?int $id;

    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function dataProviderId(): int
    {
        return $this->id ?? 0;
    }

    public function setDataProviderId(int $dataProviderId): void
    {
        $this->dataProviderId = $dataProviderId;
    }

    public function data(): DataPosition
    {
        if($this->dataProviderId() !== null) {
            try {
                return app(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class)
                    ->getById($this->dataProviderId());
            } catch (ModelNotFoundException $e) {
                return new DataPositionDummy($this->dataProviderId());
            }
        }
        return new DataPositionDummy();
    }

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'data_provider_id' => $this->dataProviderId(),
            'data' => $this->data()->toArray()
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    public function roles(): Collection
    {
        return new Collection();
    }

    public function tags(): Collection
    {
        return new Collection();
    }

    public function addTag(PositionTag $roleTag): void
    {
    }

    public function removeTag(PositionTag $roleTag): void
    {
    }
}
