<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag;

class GroupTagCategoryObserverCascadeDelete
{

    /**
     * @var GroupTag
     */
    private $groupTagRepository;

    public function __construct(GroupTag $groupTagRepository)
    {
        $this->groupTagRepository = $groupTagRepository;
    }

    public function delete(GroupTagCategory $groupTagCategory)
    {
        $tags = $this->groupTagRepository->allThroughTagCategory($groupTagCategory);
        foreach($tags as $tag) {
            $this->groupTagRepository->delete($tag->id());
        }
    }
    
}