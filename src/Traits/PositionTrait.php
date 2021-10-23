<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\DataPosition as DataPositionModel;
use BristolSU\ControlDB\Contracts\Repositories\DataPosition as DataPositionRepository;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Position;
use BristolSU\ControlDB\Models\Dummy\DataPositionDummy;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

/**
 * Implements common methods using repositories required by the position model interface
 */
trait PositionTrait
{

    /**
     * Get the data model for this position
     * 
     * @return DataPositionModel
     */
    public function data(): DataPositionModel
    {
        try {
            return app(\BristolSU\ControlDB\Contracts\Repositories\DataPosition::class)->getById($this->dataProviderId());
        } catch (ModelNotFoundException $e) { }
        return new DataPositionDummy($this->dataProviderId());
    }

    /**
     * Set the ID of the data provider
     *
     * @param int $dataProviderId
     */
    public function setDataProviderId(int $dataProviderId): void
    {
        app(Position::class)->update($this->id(), $dataProviderId);
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

    /**
     * Add a tag to the position
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag $positionTag
     */
    public function addTag(\BristolSU\ControlDB\Contracts\Models\Tags\PositionTag $positionTag): void
    {
        app(PositionPositionTag::class)->addTagToPosition($positionTag, $this);
    }

    /**
     * Remove a tag from the position
     * 
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag $positionTag
     */
    public function removeTag(\BristolSU\ControlDB\Contracts\Models\Tags\PositionTag $positionTag): void
    {
        app(PositionPositionTag::class)->removeTagFromPosition($positionTag, $this);
    }
    
}