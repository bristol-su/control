<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\DataPosition as DataPositionModel;
use BristolSU\ControlDB\Contracts\Repositories\DataPosition as DataPositionRepository;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use Illuminate\Support\Collection;

trait PositionTrait
{

    public function data(): DataPositionModel
    {
        return app(DataPositionRepository::class)->getById($this->dataProviderId());
    }

    /**
     * Roles with this position
     *
     * @return Collection
     */
    public function roles(): Collection
    {
        return app(\BristolSU\ControlDB\Contracts\Repositories\Role::class)->allThroughPosition($this);
    }

    /**
     * Tags the position is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return app(PositionPositionTag::class)->getTagsThroughPosition($this);
    }

    public function addTag(\BristolSU\ControlDB\Contracts\Models\Tags\PositionTag $positionTag): void
    {
        app(PositionPositionTag::class)->addTagToPosition($positionTag);
    }

    public function removeTag(\BristolSU\ControlDB\Contracts\Models\Tags\PositionTag $positionTag): void
    {
        app(PositionPositionTag::class)->removeTagFromPosition($positionTag);
    }


}