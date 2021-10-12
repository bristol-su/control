<?php

namespace BristolSU\ControlDB\Models\Lazy;

use BristolSU\ControlDB\Contracts\Models\DataUser;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Models\User as UserContract;
use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use Illuminate\Support\Collection;

class LazyUser extends LazyModel implements UserContract
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

    public function data(): DataUser
    {
        return $this->model()->data();
    }

    public function tags(): Collection
    {
        return $this->model()->tags();
    }

    public function roles(): Collection
    {
     return $this->model()->roles();
    }

    public function groups(): Collection
    {
        return $this->model()->groups();
    }

    public function addTag(UserTag $userTag): void
    {
        $this->model()->addTag($userTag);
    }

    public function removeTag(UserTag $userTag): void
    {
        $this->model()->removeTag($userTag);
    }

    public function addRole(Role $role): void
    {
        $this->model()->addRole($role);
    }

    public function removeRole(Role $role): void
    {
        $this->model()->removeRole($role);
    }

    public function addGroup(Group $group): void
    {
        $this->model()->addGroup($group);
    }

    public function removeGroup(Group $group): void
    {
        $this->model()->removeGroup($group);
    }

    protected function resolveModelFromId(int $id)
    {
        return app(UserRepository::class)->getById($id);
    }
}
