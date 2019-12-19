<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\Support\Control\Contracts\Models\Group;
use BristolSU\Support\Control\Contracts\Models\Position;
use BristolSU\Support\Control\Contracts\Models\Role as RoleContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Role
 * @package BristolSU\ControlDB\Models
 */
class Role extends RoleContract
{

    protected $table = 'control_roles';

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
     * ID of the position
     *
     * @return mixed
     */
    public function positionId()
    {
        return $this->position_id;
    }

    /**
     * ID of the group
     *
     * @return mixed
     */
    public function groupId()
    {
        return $this->group_id;
    }

    /**
     * Custom name of the position.
     *
     * This does not need to be the same as the actual position name. It may instead be anything you like, to allow for
     * more granular control over the positions and roles owned by an individual, whilst not creating too many positions.
     *
     * @return string
     */
    public function positionName(): string
    {
        // TODO Should return custom position name
        return $this->position()->name();
    }

    /**
     * Position belonging to the role
     *
     * @return Position
     */
    public function position(): Position
    {
        // TODO Not working
        return $this->positionRelationship;
    }

    /**
     * Group belonging to the role
     *
     * @return Group
     */
    public function group(): Group
    {
        // TODO Not working
        return $this->groupRelationship;
    }

    /**
     * Users who occupy the role
     *
     * @return Collection
     */
    public function users(): Collection
    {
        return $this->userRelationship;
    }

    /**
     * Tags the role is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return $this->tagRelationship;
    }

    /**
     * Get the ID of the role
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    public function positionRelationship()
    {
        return $this->belongsTo(\BristolSU\ControlDB\Models\Position::class, 'position_id');
    }

    public function groupRelationship()
    {
        return $this->belongsTo(\BristolSU\ControlDB\Models\Group::class, 'group_id');
    }

    public function userRelationship()
    {
        return $this->belongsToMany(User::class, 'control_role_user');
    }

    public function tagRelationship()
    {
        
    }
}
