<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory as GroupTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory as GroupTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class GroupTag
 */

class GroupTagCategory implements GroupTagCategoryContract
{

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::all();
    }

    /**
     * @inheritDoc
     */
    public function getByReference(string $reference): GroupTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): GroupTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::where('id', $id)->firstOrFail();
    }

    public function create(string $name, string $description, string $reference): GroupTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTagCategory::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
        ]);
    }

    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }
    
}
