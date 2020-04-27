<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory;
use Illuminate\Support\Collection;

/**
 * Supplies implementations of common functions required by a position tag category model by resolving repositories.
 */
trait PositionTagCategoryTrait
{

    /**
     * All tags under this tag category
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return app(PositionTag::class)->allThroughTagCategory($this);
    }

    /**
     * Set the name of the tag category
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        app(PositionTagCategory::class)->update($this->id(), $name, $this->description(), $this->reference());
    }

    /**
     * Set the description of the tag category
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        app(PositionTagCategory::class)->update($this->id(), $this->name(), $description, $this->reference());
    }

    /**
     * Set the reference of the tag category
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        app(PositionTagCategory::class)->update($this->id(), $this->name(), $this->description(), $reference);
    }
    
}