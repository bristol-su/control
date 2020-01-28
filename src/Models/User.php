<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\Contracts\Models\User as UserContract;
use BristolSU\ControlDB\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package BristolSU\ControlDB\Models
 */
class User extends Model implements UserContract
{
    use SoftDeletes, UserTrait;

    protected $table = 'control_users';

    protected $fillable = ['data_provider_id'];

    protected $appends = [
        'data'
    ];

    public function getDataAttribute()
    {
        return $this->data();
    }

    /**
     * ID of the user
     *
     * @return mixed
     */
    public function id(): int
    {
        return $this->id;
    }


    public function dataProviderId(): int
    {
        return $this->data_provider_id;
    }

    public function setDataProviderId(int $dataProviderId): void
    {
        $this->data_provider_id = $dataProviderId;
        $this->save();
    }
}
