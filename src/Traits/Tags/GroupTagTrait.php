<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory;
use Illuminate\Support\Collection;

trait GroupTagTrait
{

    public function category(): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory
    {
        return app(GroupTagCategory::class)->getById($this->id());
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
     * Groups who have this tag
     *
     * @return Collection
     */
    public function groups(): Collection
    {
        return app(GroupGroupTag::class)->getGroupsThroughTag($this);
    }

    public function addGroup(Group $group): void
    {
        app(GroupGroupTag::class)->addTagToGroup($this, $group);
    }

    public function removeGroup(Group $group): void
    {
        app(GroupGroupTag::class)->removeTagFromGroup($this, $group);
    }
    
}