<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory;
use Illuminate\Support\Collection;

/**
 * Supplies implementations of common functions required by a group tag model by resolving repositories.
 */
trait GroupTagTrait
{

    /**
     * Get the group tag category of the group tag
     * 
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory
     */
    public function category(): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory
    {
        return app(GroupTagCategory::class)->getById($this->categoryId());
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

    /**
     * Tag a group with the group tag
     * 
     * @param Group $group
     */
    public function addGroup(Group $group): void
    {
        app(GroupGroupTag::class)->addTagToGroup($this, $group);
    }

    /**
     * Untag a group from the group tag
     *
     * @param Group $group
     */
    public function removeGroup(Group $group): void
    {
        app(GroupGroupTag::class)->removeTagFromGroup($this, $group);
    }
    
}