<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag as PositionTagContract;
use BristolSU\ControlDB\Models\Tags\PositionTag as PositionTagModel;
use Illuminate\Support\Collection;

/**
 * Handles position tags
 */
class PositionTag implements PositionTagContract
{

    /**
     * Get all position tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\PositionTag[]
     */
    public function all(): Collection
    {
        return PositionTagModel::all();
    }

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
    {
        $fullTagReference = explode('.', $reference);
        $categoryReference = $fullTagReference[0];
        $tagReference = $fullTagReference[1];
        $tagCategory = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory::class)->getByReference($categoryReference);

        return PositionTagModel::where([
            'reference' => $tagReference,
            'tag_category_id' => $tagCategory->id()
        ])->firstOrFail();
    }

    /**
     * Get a position tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
    {
        return PositionTagModel::findOrFail($id);
    }

    /**
     * Create a position tag
     *
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTag::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
            'tag_category_id' => $tagCategoryId
        ]);
    }

    /**
     * Delete a position tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void
    {
        $this->getById($id)->delete();
    }

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory $positionTagCategory
     * @return Collection|\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag[] Tags with the given position tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory $positionTagCategory): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\PositionTag::where('tag_category_id', $positionTagCategory->id())->get();
    }

    /**
     * Update a position tag
     *
     * @param int $id
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function update(int $id, string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
    {
        $positionTag = $this->getById($id)->fill([
            'name' => $name, 'description' => $description, 'reference' => $reference, 'tag_category_id' => $tagCategoryId
        ]);
        $positionTag->save();
        return $positionTag;
    }
}
