<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag;
use Illuminate\Support\Collection;

/**
 * Supplies implementations of common functions required by a role tag category model by resolving repositories.
 */
trait RoleTagCategoryTrait
{

    /**
     * All tags under this tag category
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return app(RoleTag::class)->allThroughTagCategory($this);
    }
    
}