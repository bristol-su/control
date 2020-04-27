<?php

namespace BristolSU\ControlDB\Traits\Tags;

use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Repositories\Tags\UserTagCategory;
use Illuminate\Support\Collection;

/**
 * Supplies implementations of common functions required by a user tag model by resolving repositories.
 */
trait UserTagTrait
{

    /**
     * Get the user tag category of the user tag
     *
     * @return \BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory
     */
    public function category(): \BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory
    {
        return app(UserTagCategory::class)->getById($this->categoryId());
    }

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
     * Users who have this tag
     *
     * @return Collection
     */
    public function users(): Collection
    {
        return app(UserUserTag::class)->getUsersThroughTag($this);
    }

    /**
     * Tag a user with the user tag
     *
     * @param User $user
     */
    public function addUser(User $user): void
    {
        app(UserUserTag::class)->addTagToUser($this, $user);
    }

    /**
     * Untag a user from the user tag
     *
     * @param User $user
     */
    public function removeUser(User $user): void
    {
        app(UserUserTag::class)->removeTagFromUser($this, $user);
    }

    /**
     * Set the name of the tag
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        app(UserTag::class)->update($this->id(), $name, $this->description(), $this->reference(), $this->categoryId());
    }

    /**
     * Set the description of the Tag
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        app(UserTag::class)->update($this->id(), $this->name(), $description, $this->reference(), $this->categoryId());
    }

    /**
     * Set the reference of the tag
     *
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        app(UserTag::class)->update($this->id(), $this->name(), $this->description(), $reference, $this->categoryId());
    }

    /**
     * Set the tag category ID
     *
     * @param int $categoryId
     */
    public function setTagCategoryId($categoryId): void
    {
        app(UserTag::class)->update($this->id(), $this->name(), $this->description(), $this->reference(), $categoryId);
    }
    
}