<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory;
use Illuminate\Support\Collection;

trait PositionTagTrait
{

    /**
     * Full reference of the tag
     *
     * This should be the tag category reference and the tag reference, separated with a period.
     * @return string
     */
    public function fullReference(): string
    {
        return $this->category()->reference() . '.' . $this->reference();
    }

    /**
     * Tag Category
     *
     * @return PositionTagCategory
     */
    public function category(): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory
    {
        return app(PositionTagCategory::class)->getById($this->id());
    }

    /**
     * Positions who have this tag
     *
     * @return Collection
     */
    public function positions(): Collection
    {
        return app(PositionPositionTag::class)->getPositionsThroughTag($this);
    }

    public function addPosition(Position $position): void
    {
        app(PositionPositionTag::class)->addTagToPosition($this, $position);
    }

    public function removePosition(Position $position): void
    {
        app(PositionPositionTag::class)->removeTagFromPosition($this, $position);
    }
    
}