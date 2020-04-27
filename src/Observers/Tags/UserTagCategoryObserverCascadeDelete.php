<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag;

class UserTagCategoryObserverCascadeDelete
{

    /**
     * @var UserTag
     */
    private $userTagRepository;

    public function __construct(UserTag $userTagRepository)
    {
        $this->userTagRepository = $userTagRepository;
    }

    public function delete(UserTagCategory $userTagCategory)
    {
        $tags = $this->userTagRepository->allThroughTagCategory($userTagCategory);
        foreach($tags as $tag) {
            $this->userTagRepository->delete($tag->id());
        }
    }
    
}