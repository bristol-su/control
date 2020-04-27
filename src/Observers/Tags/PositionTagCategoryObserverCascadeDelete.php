<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag;

class PositionTagCategoryObserverCascadeDelete
{

    /**
     * @var PositionTag
     */
    private $positionTagRepository;

    public function __construct(PositionTag $positionTagRepository)
    {
        $this->positionTagRepository = $positionTagRepository;
    }

    public function delete(PositionTagCategory $positionTagCategory)
    {
        $tags = $this->positionTagRepository->allThroughTagCategory($positionTagCategory);
        foreach($tags as $tag) {
            $this->positionTagRepository->delete($tag->id());
        }
    }
    
}