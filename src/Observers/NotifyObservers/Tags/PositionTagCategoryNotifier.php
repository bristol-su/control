<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory as PositionTagCategoryModel;
use BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTagCategory as PositionTagCategoryRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class PositionTagCategoryNotifier extends Notifier implements PositionTagCategoryRepository
{

    /**
     * @var PositionTagCategoryRepository
     */
    private $positionTagCategoryRepository;

    public function __construct(PositionTagCategoryRepository $positionTagCategoryRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, PositionTagCategoryRepository::class);
        $this->positionTagCategoryRepository = $positionTagCategoryRepository;
    }

    /**
     * Get all position tag categories
     *
     * @return Collection|PositionTagCategoryModel[]
     */
    public function all(): Collection
    {
        return $this->positionTagCategoryRepository->all();
    }

    /**
     * Get a tag category by the reference
     *
     * @param string $reference Reference of the tag
     * @return PositionTagCategoryModel
     */
    public function getByReference(string $reference): PositionTagCategoryModel
    {
        return $this->positionTagCategoryRepository->getByReference($reference);
    }

    /**
     * Get a position tag category by id
     *
     * @param int $id
     * @return PositionTagCategoryModel
     */
    public function getById(int $id): PositionTagCategoryModel
    {
        return $this->positionTagCategoryRepository->getById($id);
    }

    /**
     * Delete a position tag category
     *
     * @param int $id ID of the position tag category to delete
     */
    public function delete(int $id): void
    {
        $positionTagCategory = $this->getById($id);
        $this->positionTagCategoryRepository->delete($id);
        $this->notify('delete', $positionTagCategory);
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
        $positionTagCategory = $this->positionTagCategoryRepository->create($name, $description, $reference);
        $this->notify('create', $positionTagCategory);
        return $positionTagCategory;
    }

    /**
     * Update a position tag category
     *
     * @param int $id
     * @param string $name Name of the position tag category
     * @param string $description Description of the position tag category
     * @param string $reference Reference of the position tag category
     * @return PositionTagCategoryModel New position tag category
     */
    public function update(int $id, string $name, string $description, string $reference): PositionTagCategoryModel
    {
        $oldPositionTagCategory = $this->getById($id);
        $newPositionTagCategory = $this->positionTagCategoryRepository->update($id, $name, $description, $reference);
        $this->notify('update', $oldPositionTagCategory, $newPositionTagCategory);
        return $newPositionTagCategory;
    }
}