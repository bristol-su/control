<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory;
use Illuminate\Support\Collection;

/**
 * Supplies implementations of common functions required by a position tag model by resolving repositories.
 */
trait PositionTagTrait
{

    /**
     * Get the position tag category of the position tag
     *
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory
     */
    public function category(): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory
    {
        return app(PositionTagCategory::class)->getById($this->categoryId());
    }

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
     * Positions who have this tag
     *
     * @return Collection
     */
    public function positions(): Collection
    {
        return app(PositionPositionTag::class)->getPositionsThroughTag($this);
    }

    /**
     * Tag a position with the position tag
     *
     * @param Position $position
     */
    public function addPosition(Position $position): void
    {
        app(PositionPositionTag::class)->addTagToPosition($this, $position);
    }

    /**
     * Untag a position from the position tag
     *
     * @param Position $position
     */
    public function removePosition(Position $position): void
    {
        app(PositionPositionTag::class)->removeTagFromPosition($this, $position);
    }

    /**
     * Set the name of the tag
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        app(PositionTag::class)->update($this->id(), $name, $this->description(), $this->reference(), $this->categoryId());
    }

    /**
     * Set the description of the Tag
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        app(PositionTag::class)->update($this->id(), $this->name(), $description, $this->reference(), $this->categoryId());
    }

    /**
     * Set the reference of the tag
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        app(PositionTag::class)->update($this->id(), $this->name(), $this->description(), $reference, $this->categoryId());
    }

    /**
     * Set the tag category ID
     *
     * @param int $categoryId
     */
    public function setTagCategoryId($categoryId): void
    {
        app(PositionTag::class)->update($this->id(), $this->name(), $this->description(), $this->reference(), $categoryId);
    }
}