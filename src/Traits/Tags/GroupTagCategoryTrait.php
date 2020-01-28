<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag;
use Illuminate\Support\Collection;

trait GroupTagCategoryTrait
{

    /**
     * All tags under this tag category
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return app(GroupTag::class)->allThroughTagCategory($this);
    }
    
}