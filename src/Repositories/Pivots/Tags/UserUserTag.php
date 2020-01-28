<?php

namespace BristolSU\ControlDB\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag as UserUserTagContract;
use BristolSU\ControlDB\Models\Pivots\UserUser as UserUserPivotModel;
use Illuminate\Support\Collection;

class UserUserTag implements UserUserTagContract
{

    /**
     * @inheritDoc
     */
    public function addTagToUser(UserTag $userTag, User $user): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\UserUserTag::create([
            'tag_id' => $userTag->id(), 'taggable_id' => $user->id()
        ]);
    }

    /**
     * @inheritDoc
     */
    public function removeTagFromUser(UserTag $userTag, User $user): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\UserUserTag::where([
            'tag_id' => $userTag->id(), 'taggable_id' => $user->id()
        ])->delete();    
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
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