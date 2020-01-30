<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory as GroupTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Manages group tag categories
 */
class GroupTagCategory implements GroupTagCategoryContract
{

    /**
     * Get all group tag categories
     *
     * @return Collection|GroupTagCategoryModel[]
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::all();
    }
    
    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return GroupTagCategoryModel
     */
    public function getByReference(string $reference): GroupTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * Get a group tag category by id
     *
     * @param int $id
     * @return GroupTagCategoryModel
     */
    public function getById(int $id): GroupTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::where('id', $id)->firstOrFail();
    }

    /**
     * Create a group tag category
     *
     * @param string $name Name of the group tag category
     * @param string $description Description of the group tag category
     * @param string $reference Reference of the group tag category
     * @return GroupTagCategoryModel New group tag category
     */
    public function create(string $name, string $description, string $reference): GroupTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
        ]);
    }

    /**
     * Delete a group tag category
     *
     * @param int $id ID of the group tag category to delete
     */
    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }
    
}
