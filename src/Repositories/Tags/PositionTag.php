<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\Support\Control\Contracts\Models\Position;
use BristolSU\Support\Control\Contracts\Models\Tags\PositionTagCategory;
use BristolSU\Support\Control\Contracts\Repositories\Tags\PositionTag as PositionTagContract;
use Illuminate\Support\Collection;

/**
 * Class PositionTag
 * @package BristolSU\ControlDB\Repositories
 */
class PositionTag implements PositionTagContract
{
    /**
     * Get all position tags
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTag::all();
    }

    /**
     * Get all position tags which a position is tagged with
     *
     * @param Position $position
     * @return Collection
     */
    public function allThroughPosition(Position $position): Collection
    {
        return $position->tags();
    }

    /**
     * Get a tag by the full reference
     *
     * @param string $reference
     * @return mixed
     */
    public function getTagByFullReference(string $reference): \BristolSU\Support\Control\Contracts\Models\Tags\PositionTag
    {
        return $this->all()->filter(function(\BristolSU\ControlDB\Models\Tags\PositionTag $tag) use ($reference) {
            return $reference === $tag->fullReference();
        })->firstOrFail();
    }

    /**
     * Get a position tag by id
     *
     * @param int $id
     * @return \BristolSU\Support\Control\Contracts\Models\Tags\PositionTag
     */
    public function getById(int $id): \BristolSU\Support\Control\Contracts\Models\Tags\PositionTag
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTag::findOrFail($id);
    }

    /**
     * Get all position tags belonging to a position tag category
     *
     * @param PositionTagCategory $positionTagCategory
     * @return Collection
     */
    public function allThroughPositionTagCategory(PositionTagCategory $positionTagCategory): Collection
    {
        return $positionTagCategory->tags();
    }
}
