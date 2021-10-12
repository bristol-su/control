<?php

namespace BristolSU\ControlDB\Models\Lazy;

use BristolSU\ControlDB\Contracts\Models\DataGroup;
use BristolSU\ControlDB\Contracts\Models\Group as GroupContract;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Group as GroupRepository;
use Illuminate\Support\Collection;

class LazyGroup extends LazyModel implements GroupContract
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

    public function data(): DataGroup
    {
        return $this->model()->data();
    }

    protected function resolveModelFromId(int $id)
    {
        return app(GroupRepository::class)->getById($id);
    }

    public function members(): Collection
    {
        return $this->model()->members();
    }

    public function roles(): Collection
    {
        return $this->model()->roles();
    }

    public function tags(): Collection
    {
        return $this->model()->tags();
    }

    public function addTag(GroupTag $groupTag): void
    {
        $this->model()->addTag($groupTag);
    }

    public function removeTag(GroupTag $groupTag): void
    {
        $this->model()->removeTag($groupTag);
    }

    public function addUser(User $user): void
    {
        $this->model()->addUser($user);
    }

    public function removeUser(User $user): void
    {
        $this->model()->removeUser($user);
    }
}
