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
        $key = static::class . '@getTagsThroughUser:' . $user->id();
        if(!$this->cache->has($key)) {
            $userTags = $this->userUserTagRepository->getTagsThroughUser($user);
            $this->cache->forever($key, $userTags->map(fn(UserTag $userTag) => $userTag->id())->all());
            return $userTags;
        }
        return collect($this->cache->get($key))
            ->map(fn(int $userTagId) => app(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag::class)->getById($userTagId));
    }

    /**
     * Get all users tagged with a tag
     *
     * @param UserTag $userTag Tag to use to retrieve users
     * @return Collection|User[] Users tagged with the given tag
     */
    public function getUsersThroughTag(UserTag $userTag): Collection
    {
        $key = static::class . '@getUsersThroughTag:' . $userTag->id();
        if(!$this->cache->has($key)) {
            $users = $this->userUserTagRepository->getUsersThroughTag($userTag);
            $this->cache->forever($key, $users->map(fn(User $user) => $user->id())->all());
            return $users;
        }
        return collect($this->cache->get($key))
            ->map(fn(int $userId) => app(\BristolSU\ControlDB\Contracts\Repositories\User::class)->getById($userId));
    }
}
