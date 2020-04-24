<?php

namespace BristolSU\ControlDB\Observers\NotifyObservers\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag as GroupGroupTagRepository;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\Notifier;
use BristolSU\ControlDB\Observers\NotifyObservers\Framework\ObserverStore;
use Illuminate\Support\Collection;

class GroupGroupTagNotifier extends Notifier implements GroupGroupTagRepository
{

    /**
     * @var GroupGroupTagRepository
     */
    private $groupGroupTagRepository;

    public function __construct(GroupGroupTagRepository $groupGroupTagRepository, ObserverStore $observerStore)
    {
        parent::__construct($observerStore, GroupGroupTagRepository::class);
        $this->groupGroupTagRepository = $groupGroupTagRepository;
    }

    /**
     * Tag a group
     *
     * @param GroupTag $groupTag Tag to tag the group with
     * @param Group $group Group to tag
     * @return void
     */
    public function addTagToGroup(GroupTag $groupTag, Group $group): void
    {
        $this->groupGroupTagRepository->addTagToGroup($groupTag, $group);
        $this->notify('addTagToGroup', $groupTag, $group);
    }

    /**
     * Remove a tag from a group
     *
     * @param GroupTag $groupTag Tag to remove from the group
     * @param Group $group Group to remove the tag from
     * @return void
     */
    public function removeTagFromGroup(GroupTag $groupTag, Group $group): void
    {
        $this->groupGroupTagRepository->removeTagFromGroup($groupTag, $group);
        $this->notify('removeTagFromGroup', $groupTag, $group);    
    }

    /**
     * Get all tags a group is tagged with
     *
     * @param Group $group Group to retrieve tags from
     * @return Collection|GroupTag[] Tags the group is tagged with
     */
    public function getTagsThroughGroup(Group $group): Collection
    {
        return $this->groupGroupTagRepository->getTagsThroughGroup($group);
    }

    /**
     * Get all groups tagged with a tag
     *
     * @param GroupTag $groupTag Tag to use to retrieve groups
     * @return Collection|Group[] Groups tagged with the given tag
     */
    public function getGroupsThroughTag(GroupTag $groupTag): Collection
    {
        return $this->groupGroupTagRepository->getGroupsThroughTag($groupTag);
    }
}