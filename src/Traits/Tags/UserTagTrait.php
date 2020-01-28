<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory;
use Illuminate\Support\Collection;

trait UserTagTrait
{

    /**
     * Full reference of the tag
     *
     * This should be the tag category reference and the tag reference, separated with a period.
     * @return string
     */
    public function fullReference(): string
    {
        return $this->category()->reference() . '.' . $this->reference();
    }

    /**
     * Tag Category
     *
     * @return UserTagCategory
     */
    public function category(): \BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory
    {
        return app(UserTagCategory::class)->getById($this->id());
    }

    /**
     * Users who have this tag
     *
     * @return Collection
     */
    public function users(): Collection
    {
        return app(UserUserTag::class)->getUsersThroughTag($this);
    }

    public function addUser(User $user): void
    {
        app(UserUserTag::class)->addTagToUser($this, $user);
    }

    public function removeUser(User $user): void
    {
        app(UserUserTag::class)->removeTagFromUser($this, $user);
    }
    
}