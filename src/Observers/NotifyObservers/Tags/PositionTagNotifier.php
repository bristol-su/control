<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Tags;

use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag as PositionTagRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class PositionTagNotifier extends Notifier implements PositionTagRepository
{

    /**
     * @var PositionTagRepository
     */
    private $positionTagRepository;

    public function __construct(PositionTagRepository $positionTagRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, PositionTagRepository::class);
        $this->positionTagRepository = $positionTagRepository;
    }

    /**
     * Get all position tags
     *
     * @return Collection|\BristolSU\ControlDB\Contracts\Models\Tags\PositionTag[]
     */
    public function all(): Collection
    {
        return $this->positionTagRepository->all();
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
        return $this->positionTagRepository->getTagByFullReference($reference);
    }

    /**
     * Get a position tag by id
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\Tags\PositionTag
    {
        return $this->positionTagRepository->getById($id);
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
        $positionTag = $this->positionTagRepository->create($name, $description, $reference, $tagCategoryId);
        $this->notify('create', $positionTag);
        return $positionTag;
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
        $oldPositionTag = $this->getById($id);
        $newPositionTag = $this->positionTagRepository->update($id, $name, $description, $reference, $tagCategoryId);
        $this->notify('update', $oldPositionTag, $newPositionTag);
        return $newPositionTag;
    }

    /**
     * Delete a position tag
     *
     * @param int $id ID of the tag to delete
     */
    public function delete(int $id): void
    {
        $positionTag = $this->getById($id);
        $this->positionTagRepository->delete($id);
        $this->notify('delete', $positionTag);
    }

    /**
     * Get all tags through a tag category
     *
     * @param \BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory $positionTagCategory
     * @return Collection|PositionTagRepository Tags with the given position tag category
     */
    public function allThroughTagCategory(\BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory $positionTagCategory): Collection
    {
        return $this->positionTagRepository->allThroughTagCategory($positionTagCategory);
    }
}