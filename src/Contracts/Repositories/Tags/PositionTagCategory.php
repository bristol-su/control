<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModel;
use Illuminate\Support\Collection;

/**
 * Manages position tag categories
 */
interface PositionTagCategory
{

    /**
     * Get all position tag categories
     *
     * @return Collection|PositionTagCategoryModel[]
     */
    public function all(): Collection;

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return PositionTagCategoryModel
     */
    public function getByReference(string $reference): PositionTagCategoryModel;

    /**
     * Get a position tag category by id
     *
     * @param int $id
     * @return PositionTagCategoryModel
     */
    public function getById(int $id): PositionTagCategoryModel;

    /**
     * Delete a position tag category
     *
     * @param int $id ID of the position tag category to delete
     */
    public function delete(int $id): void;

    /**
     * Create a position tag category
     *
     * @param string $name Name of the position tag category
     * @param string $description Description of the position tag category
     * @param string $reference Reference of the position tag category
     * @return PositionTagCategoryModel New position tag category
     */
    public function create(string $name, string $description, string $reference): PositionTagCategoryModel;

    /**
     * Update a position tag category
     *
     * @param int $id
     * @param string $name Name of the position tag category
     * @param string $description Description of the position tag category
     * @param string $reference Reference of the position tag category
     * @return PositionTagCategoryModel Updated position tag category
     */
    public function update(int $id, string $name, string $description, string $reference): PositionTagCategoryModel;
}
