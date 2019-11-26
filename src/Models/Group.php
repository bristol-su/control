<?php

namespace BristolSU\ControlDB\Models;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\Support\Control\Contracts\Models\Group as GroupContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Group
 * @package BristolSU\ControlDB\Models
 */
class Group extends Model implements GroupContract
{

    protected $table = 'control_groups';

    protected $guarded = [];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id();
    }

    /**
     * ID of the group
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        // TODO: Implement getAuthPassword() method.
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }

    /**
     * Name of the group
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Contact email address for the group
     *
     * @return string|null
     */
    public function email(): ?string
    {
        return $this->email;
    }

    /**
     * Data platform ID of the group
     *
     * @return int
     */
    public function dataPlatformId(): int
    {
        return $this->data_provider_id;
    }

    /**
     * Members of the group
     *
     * @return Collection
     */
    public function members(): Collection
    {
        return $this->userRelationship;
    }

    /**
     * Roles belonging to the group
     *
     * @return Collection
     */
    public function roles(): Collection
    {
        return $this->roleRelationship;
    }

    /**
     * Tags the group is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return $this->tagRelationship;
    }

    public function userRelationship()
    {
        return $this->belongsToMany(User::class, 'control_group_user');
    }

    public function roleRelationship()
    {
        // TODO Only return occupied roles
        return $this->hasMany(Role::class);
    }

    public function tagRelationship()
    {
        return $this->morphToMany(
            GroupTag::class, 
            'taggable', 
            'control_taggables', 
            'taggable_id', 
            'tag_id'
            );
    }
}
