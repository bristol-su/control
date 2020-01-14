<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Position as PositionContract;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryContract;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag as PositionTagModel;
use Illuminate\Support\Collection;

/**
 * Interface PositionTag
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
abstract class PositionTag
{

    /**
     * Get all position tags
     *
     * @return Collection
     */
    abstract public function all(): Collection;

    /**
     * Get all position tags which a position is tagged with
     *
     * @param PositionContract $position
     * @return Collection
     */
    public function allThroughPosition(PositionContract $position): Collection {
        return $position->tags();
    }

    /**
     * Get a tag by the full reference
     *
     * @param $reference
     * @return mixed
     */
    abstract public function getTagByFullReference(string $reference): PositionTagModel;

    /**
     * Get a position tag by id
     *
     * @param int $id
     * @return PositionTagModel
     */
    abstract public function getById(int $id): PositionTagModel;

    /**
     * Get all position tags belonging to a position tag category
     *
     * @param PositionTagCategoryContract $positionTagCategory
     * @return Collection
     */
    public function allThroughPositionTagCategory(PositionTagCategoryContract $positionTagCategory): Collection {
        return $positionTagCategory->tags();
    }

    abstract public function create(string $name, string $description, string $reference, $tagCategoryId): PositionTagModel;

    abstract public function delete(int $id);
}
