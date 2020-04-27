<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag as PositionPositionTagRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class PositionPositionTagNotifier extends Notifier implements PositionPositionTagRepository
{

    /**
     * @var PositionPositionTagRepository
     */
    private $positionPositionTagRepository;

    public function __construct(PositionPositionTagRepository $positionPositionTagRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, PositionPositionTagRepository::class);
        $this->positionPositionTagRepository = $positionPositionTagRepository;
    }

    /**
     * Tag a position
     *
     * @param PositionTag $positionTag Tag to tag the position with
     * @param Position $position Position to tag
     * @return void
     */
    public function addTagToPosition(PositionTag $positionTag, Position $position): void
    {
        $this->positionPositionTagRepository->addTagToPosition($positionTag, $position);
        $this->notify('addTagToPosition', $positionTag, $position);
    }

    /**
     * Remove a tag from a position
     *
     * @param PositionTag $positionTag Tag to remove from the position
     * @param Position $position Position to remove the tag from
     * @return void
     */
    public function removeTagFromPosition(PositionTag $positionTag, Position $position): void
    {
        $this->positionPositionTagRepository->removeTagFromPosition($positionTag, $position);
        $this->notify('removeTagFromPosition', $positionTag, $position);    
    }

    /**
     * Get all tags a position is tagged with
     *
     * @param Position $position Position to retrieve tags from
     * @return Collection|PositionTag[] Tags the position is tagged with
     */
    public function getTagsThroughPosition(Position $position): Collection
    {
        return $this->positionPositionTagRepository->getTagsThroughPosition($position);
    }

    /**
     * Get all positions tagged with a tag
     *
     * @param PositionTag $positionTag Tag to use to retrieve positions
     * @return Collection|Position[] Positions tagged with the given tag
     */
    public function getPositionsThroughTag(PositionTag $positionTag): Collection
    {
        return $this->positionPositionTagRepository->getPositionsThroughTag($positionTag);
    }
}