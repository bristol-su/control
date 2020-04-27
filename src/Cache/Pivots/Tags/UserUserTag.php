<?php

namespace BristolSU\ControlDB\Cache\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag as UserUserTagRepository;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;

class UserUserTag implements UserUserTagRepository
{
    /**
     * @var UserUserTagRepository
     */
    private $userUserTagRepository;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(UserUserTagRepository $userUserTagRepository, Repository $cache)
    {
        $this->userUserTagRepository = $userUserTagRepository;
        $this->cache = $cache;
    }

    /**
     * Tag a user
     *
     * @param UserTag $userTag Tag to tag the user with
     * @param User $user User to tag
     * @return void
     */
    public function addTagToUser(UserTag $userTag, User $user): void
    {
        $this->userUserTagRepository->addTagToUser($userTag, $user);
    }

    /**
     * Remove a tag from a user
     *
     * @param UserTag $userTag Tag to remove from the user
     * @param User $user User to remove the tag from
     * @return void
     */
    public function removeTagFromUser(UserTag $userTag, User $user): void
    {
        $this->userUserTagRepository->removeTagFromUser($userTag, $user);
    }

    /**
     * Get all tags a user is tagged with
     *
     * @param User $user User to retrieve tags from
     * @return Collection|UserTag[] Tags the user is tagged with
     */
    public function getTagsThroughUser(User $user): Collection
    {
        return $this->cache->rememberForever(static::class . '@getTagsThroughUser:' . $user->id(), function() use ($user) {
            return $this->userUserTagRepository->getTagsThroughUser($user);
        });
    }

    /**
     * Get all users tagged with a tag
     *
     * @param UserTag $userTag Tag to use to retrieve users
     * @return Collection|User[] Users tagged with the given tag
     */
    public function getUsersThroughTag(UserTag $userTag): Collection
    {
        return $this->cache->rememberForever(static::class . '@getUsersThroughTag:' . $userTag->id(), function() use ($userTag) {
            return $this->userUserTagRepository->getUsersThroughTag($userTag);
        });   
    }
}