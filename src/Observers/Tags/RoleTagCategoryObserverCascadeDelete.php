<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTag;

class RoleTagCategoryObserverCascadeDelete
{

    /**
     * @var RoleTag
     */
    private $roleTagRepository;

    public function __construct(RoleTag $roleTagRepository)
    {
        $this->roleTagRepository = $roleTagRepository;
    }

    public function delete(RoleTagCategory $roleTagCategory)
    {
        $tags = $this->roleTagRepository->allThroughTagCategory($roleTagCategory);
        foreach($tags as $tag) {
            $this->roleTagRepository->delete($tag->id());
        }
    }
    
}