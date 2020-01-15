<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag as PositionTagModel;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory as PositionTagCategoryContract;
use Illuminate\Support\Collection;

/**
 * Class PositionTag
 * @package BristolSU\ControlDB\Repositories
 */
class PositionTagCategory extends PositionTagCategoryContract
{


    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::all();
    }

    /**
     * @inheritDoc
     */
    public function getByReference(string $reference): PositionTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::where('reference', $reference)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): PositionTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::where('id', $id)->firstOrFail();
    }

    public function create(string $name, string $description, string $reference): PositionTagCategoryModel
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTagCategory::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
            'type' => 'position'
        ]);
    }

    public function delete(int $id)
    {
        $this->getById($id)->delete();
    }
}
