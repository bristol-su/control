<?php

namespace BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use Illuminate\Support\Collection;

/**
 * Handles the tagging of users
 */
interface UserUserTag
{

    /**
     * Tag a user
     *
     * @param UserTag $userTag Tag to tag the user with
     * @param User $user User to tag
     * @return void 
     */
    public function addTagToUser(UserTag $userTag, User $user): void;

    /**
     * Remove a tag from a user
     *
     * @param UserTag $userTag Tag to remove from the user
     * @param User $user User to remove the tag from
     * @return void 
     */
    public function removeTagFromUser(UserTag $userTag, User $user): void;

    /**
     * Get all tags a user is tagged with
     *
     * @param User $user User to retrieve tags from
     * @return Collection|UserTag[] Tags the user is tagged with
     */
    public function getTagsThroughUser(User $user): Collection;

    /**
     * Get all users tagged with a tag
     *
     * @param UserTag $userTag Tag to use to retrieve users
     * @return Collection|User[] Users tagged with the given tag
     */
    public function getUsersThroughTag(UserTag $userTag): Collection;

}