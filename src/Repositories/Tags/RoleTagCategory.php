<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag as RoleTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\RoleTagCategory as RoleTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class RoleTag
 * @package BristolSU\ControlDB\Repositories
 */
class RoleTagCategory extends RoleTagCategoryContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::all();
    }

    /**
     * @inheritDoc
     */
    public function getByReference(string $reference): RoleTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): RoleTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::where('id', $id)->firstOrFail();
    }

    public function create(string $name, string $description, string $reference): RoleTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\RoleTagCategory::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
            'type' => 'role'
        ]);
    }

    public function delete(int $id)
    {
        $this->getById($id)->delete();
    }
}
