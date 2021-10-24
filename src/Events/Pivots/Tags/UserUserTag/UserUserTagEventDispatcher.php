<?php

namespace BristolSU\ControlDB\Events\Pivots\Tags\UserUserTag;

use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag;
use Illuminate\Support\Collection;

class UserUserTagEventDispatcher implements UserUserTag
{

    private UserUserTag $baseUserUserTag;

    public function __construct(UserUserTag $baseUserUserTag)
    {
        $this->baseUserUserTag = $baseUserUserTag;
    }

    public function addTagToUser(UserTag $userTag, User $user): void
    {
        $this->baseUserUserTag->addTagToUser($userTag, $user);
        UserTagged::dispatch($user, $userTag);
    }

    public function removeTagFromUser(UserTag $userTag, User $user): void
    {
        $this->baseUserUserTag->removeTagFromUser($userTag, $user);
        UserUntagged::dispatch($user, $userTag);
    }

    public function getTagsThroughUser(User $user): Collection
    {
        return $this->baseUserUserTag->getTagsThroughUser($user);
    }

    public function getUsersThroughTag(UserTag $userTag): Collection
    {
        return $this->baseUserUserTag->getUsersThroughTag($userTag);
    }
}
