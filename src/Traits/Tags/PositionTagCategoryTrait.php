<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag;
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
    
}