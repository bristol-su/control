<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory as UserTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory as UserTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Manages user tag categories
 */
class UserTagCategory implements UserTagCategoryContract
{

    /**
     * Get all user tag categories
     *
     * @return Collection|UserTagCategoryModel[]
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::all();
    }

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return UserTagCategoryModel
     */
    public function getByReference(string $reference): UserTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * Get a user tag category by id
     *
     * @param int $id
     * @return UserTagCategoryModel
     */
    public function getById(int $id): UserTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::where('id', $id)->firstOrFail();
    }

    /**
     * Create a user tag category
     *
     * @param string $name Name of the user tag category
     * @param string $description Description of the user tag category
     * @param string $reference Reference of the user tag category
     * @return UserTagCategoryModel New user tag category
     */
    public function create(string $name, string $description, string $reference): UserTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\UserTagCategory::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
        ]);
    }

    /**
     * Delete a user tag category
     *
     * @param int $id ID of the user tag category to delete
     */
    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }

}
