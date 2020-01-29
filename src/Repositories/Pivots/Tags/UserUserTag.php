<?php

namespace BristolSU\ControlDB\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag as UserUserTagContract;
use Illuminate\Support\Collection;

/**
 * Handles the tagging of users
 */
class UserUserTag implements UserUserTagContract
{

    /**
     * Tag a user
     *
     * @param UserTag $userTag Tag to tag the user with
     * @param User $user User to tag
     * @return void
     */
    public function addTagToUser(UserTag $userTag, User $user): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\UserUserTag::create([
            'tag_id' => $userTag->id(), 'taggable_id' => $user->id()
        ]);
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
        \BristolSU\ControlDB\Models\Pivots\Tags\UserUserTag::where([
            'tag_id' => $userTag->id(), 'taggable_id' => $user->id()
        ])->delete();    
    }

    /**
     * Get all tags a user is tagged with
     *
     * @param User $user User to retrieve tags from
     * @return Collection|UserTag[] Tags the user is tagged with
     */
    public function getTagsThroughUser(User $user): Collection
    {
        $userTagRepository = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag::class);

        return \BristolSU\ControlDB\Models\Pivots\Tags\UserUserTag::where('taggable_id', $user->id())
            ->get()->map(function(\BristolSU\ControlDB\Models\Pivots\Tags\UserUserTag $userUserTag) use ($userTagRepository) {
            return $userTagRepository->getById((int) $userUserTag->tag_id);
        })->unique(function(UserTag $user) {
            return $user->id();
        })->values();
    }

    /**
     * Get all users tagged with a tag
     *
     * @param UserTag $userTag Tag to use to retrieve users
     * @return Collection|User[] Users tagged with the given tag
     */
    public function getUsersThroughTag(UserTag $userTag): Collection
    {
        $userRepository = app(\BristolSU\ControlDB\Contracts\Repositories\User::class);

        return \BristolSU\ControlDB\Models\Pivots\Tags\UserUserTag::where('tag_id', $userTag->id())
            ->get()->map(function(\BristolSU\ControlDB\Models\Pivots\Tags\UserUserTag $userUserTag) use ($userRepository) {
                return $userRepository->getById((int) $userUserTag->taggable_id);
            })->unique(function(User $user) {
                return $user->id();
            })->values();
    }
}