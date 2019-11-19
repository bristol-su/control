<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\Support\Control\Contracts\Models\User as UserContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class User
 * @package BristolSU\ControlDB\Models
 */
class User extends Model implements UserContract
{
    protected $table = 'control_user';

    protected $fillable = ['data_provider_id'];
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
     * ID of the user
     *
     * @return mixed
     */
    public function id()
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
     * ID of the user on the data platform
     *
     * @return mixed
     */
    public function dataPlatformId()
    {
        return $this->data_provider_id;
    }

    /**
     * Tags the user is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection
    {
        return $this->tagRelationship;
    }

    /**
     * Roles the user owns
     *
     * @return Collection
     */
    public function roles(): Collection
    {
        return $this->roleRelationship;
    }

    /**
     * Groups the user is a member of
     *
     * @return Collection
     */
    public function groups(): Collection
    {
        return $this->groupRelationship;
    }

    protected function tagRelationship()
    {

    }

    protected function roleRelationship()
    {
        return $this->belongsToMany(Role::class, 'control_role_user');
    }

    protected function groupRelationship()
    {
        return $this->belongsToMany(Group::class, 'control_group_user');
    }
}
