<?php

namespace BristolSU\ControlDB\Models\Lazy;

use BristolSU\ControlDB\Contracts\Models\DataPosition;
use BristolSU\ControlDB\Contracts\Models\Position as PositionContract;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use Illuminate\Support\Collection;
use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepository;

class LazyPosition extends LazyModel implements PositionContract
{

    public function toArray()
    {
        return $this->model()->toArray();
    }

    public function toJson($options = 0)
    {
        return $this->model()->toJson($options);
    }

    public function id(): int
    {
        return $this->model()->id();
    }

    public function dataProviderId(): int
    {
        return $this->model()->dataProviderId();
    }

    public function setDataProviderId(int $dataProviderId): void
    {
        $this->model()->setDataProviderId($dataProviderId);
    }

    public function data(): DataPosition
    {
        return $this->model()->data();
    }

    protected function resolveModelFromId(int $id)
    {
        return app(PositionRepository::class)->getById($id);
    }

    public function roles(): Collection
    {
        return $this->model()->roles();
    }

    public function tags(): Collection
    {
        return $this->model()->tags();
    }

    public function addTag(PositionTag $roleTag): void
    {
        $this->model()->addTag($roleTag);
    }

    public function removeTag(PositionTag $roleTag): void
    {
        $this->model()->removeTag($roleTag);
    }
}
