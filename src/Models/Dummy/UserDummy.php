<?php

namespace BristolSU\ControlDB\Models\Dummy;

use BristolSU\ControlDB\Contracts\Models\DataUser;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class UserDummy implements User
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

    public function data(): DataUser
    {
        if($this->dataProviderId() !== null) {
            try {
                return app(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class)
                    ->getById($this->dataProviderId());
            } catch (ModelNotFoundException $e) {
                return new DataUserDummy($this->dataProviderId());
            }
        }
        return new DataUserDummy();
    }

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'data_provider_id' => $this->dataProviderId()
        ];
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    public function tags(): Collection
    {
        return new Collection();
    }

    public function roles(): Collection
    {
        return new Collection();
    }

    public function groups(): Collection
    {
        return new Collection();
    }

    public function addTag(UserTag $userTag): void
    {
    }

    public function removeTag(UserTag $userTag): void
    {
    }

    public function addRole(Role $role): void
    {
    }

    public function removeRole(Role $role): void
    {
    }

    public function addGroup(Group $group): void
    {
    }

    public function removeGroup(Group $group): void
    {
    }
}