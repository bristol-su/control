<?php

namespace BristolSU\ControlDB\Models;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Models\Group as GroupContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Group
 * @package BristolSU\ControlDB\Models
 */
class Group extends Model implements \BristolSU\ControlDB\Contracts\Models\Group
{

    use SoftDeletes;

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
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     * @return void
     */
    public function setRememberToken($value)
    {
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
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
