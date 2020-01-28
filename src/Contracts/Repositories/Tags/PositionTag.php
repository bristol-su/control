<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag as PositionTagModel;
use Illuminate\Support\Collection;

/**
 * Interface PositionTag
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
interface PositionTag
{

    /**
     * Get all position tags
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get a tag by the full reference
     *
     * @param $reference
     * @return mixed
     */
    public function getTagByFullReference(string $reference): PositionTagModel;

    /**
     * Get a position tag by id
     *
     * @param int $id
     * @return PositionTagModel
     */
    public function getById(int $id): PositionTagModel;
    

    public function create(string $name, string $description, string $reference, $tagCategoryId): PositionTagModel;

    public function delete(int $id): void;

    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory $positionTagCategory): Collection;

}
