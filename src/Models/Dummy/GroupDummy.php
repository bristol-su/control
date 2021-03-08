<?php

namespace BristolSU\ControlDB\Models\Dummy;

use BristolSU\ControlDB\Contracts\Models\DataGroup;
use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class GroupDummy implements Group
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

    public function data(): DataGroup
    {
        if($this->dataProviderId() !== null) {
            try {
                return app(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class)
                    ->getById($this->dataProviderId());
            } catch (ModelNotFoundException $e) {
                return new DataGroupDummy($this->dataProviderId());
            }
        }
        return new DataGroupDummy();
    }

    public function members(): Collection
    {
        return new Collection();
    }

    public function roles(): Collection
    {
        return new Collection();
    }

    public function tags(): Collection
    {
        return new Collection();
    }

    public function addTag(GroupTag $groupTag): void
    {
    }

    public function removeTag(GroupTag $groupTag): void
    {
    }

    public function addUser(User $user): void
    {
    }

    public function removeUser(User $user): void
    {
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
}