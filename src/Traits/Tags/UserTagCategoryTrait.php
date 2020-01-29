<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag;
use Illuminate\Support\Collection;

/**
 * Supplies implementations of common functions required by a user tag category model by resolving repositories.
 */
trait UserTagCategoryTrait
{

    /**
     * All tags under this tag category
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return app(UserTag::class)->allThroughTagCategory($this);
    }
    
}