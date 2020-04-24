<?php

namespace BristolSU\ControlDB\Cache\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\GroupGroupTag as GroupGroupTagRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class GroupGroupTag implements GroupGroupTagRepository
{
    /**
     * @var GroupGroupTagRepository
     */
    private $groupGroupTagRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(GroupGroupTagRepository $groupGroupTagRepository, Repository $cache)
    {
        $this->groupGroupTagRepository = $groupGroupTagRepository;
        $this->cache = $cache;
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
    }

    /**
     * Get all tags a group is tagged with
     *
     * @param Group $group Group to retrieve tags from
     * @return Collection|GroupTag[] Tags the group is tagged with
     */
    public function getTagsThroughGroup(Group $group): Collection
    {
        return $this->cache->rememberForever(static::class . '@getTagsThroughGroup:' . $group->id(), function() use ($group) {
            return $this->groupGroupTagRepository->getTagsThroughGroup($group);
        });
    }

    /**
     * Get all groups tagged with a tag
     *
     * @param GroupTag $groupTag Tag to use to retrieve groups
     * @return Collection|Group[] Groups tagged with the given tag
     */
    public function getGroupsThroughTag(GroupTag $groupTag): Collection
    {
        return $this->cache->rememberForever(static::class . '@getGroupsThroughTag:' . $groupTag->id(), function() use ($groupTag) {
            return $this->groupGroupTagRepository->getGroupsThroughTag($groupTag);
        });   
    }
}