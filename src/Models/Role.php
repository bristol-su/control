<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Role
 * @package BristolSU\ControlDB\Models
 */
class Role extends Model implements \BristolSU\ControlDB\Contracts\Models\Role
{

    use SoftDeletes;

    protected $table = 'control_roles';

    protected $guarded = [];

    protected $appends = [
        'data'
    ];

    public function getDataAttribute()
    {
        return $this->data();
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function data(): \BristolSU\ControlDB\Contracts\Models\DataRole {
        return app(\BristolSU\ControlDB\Contracts\Repositories\DataRole::class)->getById($this->dataProviderId());
    }

    public function dataProviderId()
    {
        return $this->data_provider_id;
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
     * Get the ID of the role
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
     * Position belonging to the role
     *
     * @return Position
     */
    public function position(): \BristolSU\ControlDB\Contracts\Models\Position
    {
        return $this->positionRelationship;
    }

    /**
     * Group belonging to the role
     *
     * @return Group
     */
    public function group(): \BristolSU\ControlDB\Contracts\Models\Group
    {
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

    public function positionRelationship()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function groupRelationship()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function userRelationship()
    {
        return $this->belongsToMany(\BristolSU\ControlDB\Models\User::class, 'control_role_user');
    }

    public function tagRelationship()
    {
        return $this->morphToMany(RoleTag::class,
            'taggable',
            'control_taggables',
            'taggable_id',
            'tag_id');
    }

    public function setGroupId(int $groupId)
    {
        $this->group_id = $groupId;
        $this->save();    
    }

    public function setPositionId(int $positionId)
    {
        $this->position_id = $positionId;
        $this->save();    
    }

    public function setDataProviderId(int $dataProviderId)
    {
        $this->data_provider_id = $dataProviderId;
        $this->save();
    }

    public function addTag(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTag $roleTag)
    {
        $this->tagRelationship()->attach($roleTag->id());
    }

    public function removeTag(\BristolSU\ControlDB\Contracts\Models\Tags\RoleTag $roleTag)
    {
        $this->tagRelationship()->detach($roleTag->id());
    }


    public function addUser(User $user)
    {
        $this->userRelationship()->attach($user->id());
    }

    public function removeUser(User $user)
    {
        $this->userRelationship()->detach($user->id());
    }
}
