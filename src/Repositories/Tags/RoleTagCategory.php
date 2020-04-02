<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory as RoleTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Manages role tag categories
 */
class RoleTagCategory implements RoleTagCategoryContract
{

    /**
     * Get all role tag categories
     *
     * @return Collection|RoleTagCategoryModel[]
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::all();
    }

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return RoleTagCategoryModel
     */
    public function getByReference(string $reference): RoleTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * Get a role tag category by id
     *
     * @param int $id
     * @return RoleTagCategoryModel
     */
    public function getById(int $id): RoleTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::findOrFail($id);
    }

    /**
     * Create a role tag category
     *
     * @param string $name Name of the role tag category
     * @param string $description Description of the role tag category
     * @param string $reference Reference of the role tag category
     * @return RoleTagCategoryModel New role tag category
     */
    public function create(string $name, string $description, string $reference): RoleTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
        ]);
    }

    /**
     * Delete a role tag category
     *
     * @param int $id ID of the role tag category to delete
     */
    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }

}
