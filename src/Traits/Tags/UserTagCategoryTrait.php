<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag;
use Illuminate\Support\Collection;

trait UserTagCategoryTrait
{

    /**
     * All tags under this tag category
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return app(UserTag::class)->allThroughUserTagCategory($this);
    }
    
}