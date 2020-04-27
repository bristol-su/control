<?php


namespace BristolSU\ControlDB\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag as GroupTagContract;
use BristolSU\ControlDB\Models\Tags\GroupTag as GroupTagModel;
use Illuminate\Support\Collection;

/**
 * Handles group tags
 */
class GroupTag implements GroupTagContract
{

    /**
     * Get all group tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\GroupTag[]
     */
    public function all(): Collection
    {
        return GroupTagModel::all();
    }

    /**
     * Get a tag by the full reference
     *
     * The full reference looks like 'tag_category_ref.tag_ref'
     *
     * @param string $reference
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function getTagByFullReference(string $reference): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        $fullTagReference = explode('.', $reference);
        $categoryReference = $fullTagReference[0];
        $tagReference = $fullTagReference[1];
        $tagCategory = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTagCategory::class)->getByReference($categoryReference);

        return GroupTagModel::where([
            'reference' => $tagReference,
            'tag_category_id' => $tagCategory->id()
        ])->firstOrFail();
    }

    /**
     * Get a group tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return GroupTagModel::findOrFail($id);
    }

    /**
     * Create a group tag
     *
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function create(string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTag::create([
            'name' => $name,
            'description' => $description,
            'reference' => $reference,
            'tag_category_id' => $tagCategoryId
        ]);
    }

    /**
     * Delete a group tag
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
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory $groupTagCategory
     * @return Collection|\BristolSU\ControlDB\Contracts\Repositories\Tags\GroupTag[] Tags with the given group tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory $groupTagCategory): Collection
    {
        return \BristolSU\ControlDB\Models\Tags\GroupTag::where('tag_category_id', $groupTagCategory->id())->get();
    }

    /**
     * Update a group tag
     *
     * @param int $id
     * @param string $name Name of the tag
     * @param string $description Description of the tag
     * @param string $reference Reference for the tag
     * @param int $tagCategoryId Category ID of the tag
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
     */
    public function update(int $id, string $name, string $description, string $reference, int $tagCategoryId): \BristolSU\ControlDB\Contracts\Models\Tags\GroupTag
    {
        $groupTag = $this->getById($id)->fill([
            'name' => $name, 'description' => $description, 'reference' => $reference, 'tag_category_id' => $tagCategoryId
        ]);
        $groupTag->save();
        return $groupTag;
    }
}
