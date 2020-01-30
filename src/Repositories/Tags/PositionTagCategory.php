<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory as PositionTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Manages position tag categories
 */
class PositionTagCategory implements PositionTagCategoryContract
{

    /**
     * Get all position tag categories
     *
     * @return Collection|PositionTagCategoryModel[]
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::all();
    }

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return PositionTagCategoryModel
     */
    public function getByReference(string $reference): PositionTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * Get a position tag category by id
     *
     * @param int $id
     * @return PositionTagCategoryModel
     */
    public function getById(int $id): PositionTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::where('id', $id)->firstOrFail();
    }

    /**
     * Create a position tag category
     *
     * @param string $name Name of the position tag category
     * @param string $description Description of the position tag category
     * @param string $reference Reference of the position tag category
     * @return PositionTagCategoryModel New position tag category
     */
    public function create(string $name, string $description, string $reference): PositionTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
        ]);
    }

    /**
     * Delete a position tag category
     *
     * @param int $id ID of the position tag category to delete
     */
    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }

}
