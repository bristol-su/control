<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\Contracts\Models\User as UserContract;
use BristolSU\ControlDB\Traits\UserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a user
 */
class User extends Model implements UserContract
{
    use SoftDeletes, UserTrait;
    
    /**
     * Table to use
     *
     * @var string
     */
    protected $table = 'control_users';

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = ['data_provider_id'];

    /**
     * Attributes to append when casting to an array
     *
     * @var array
     */
    protected $appends = [
        'data'
    ];

    /**
     * ID of the user
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * ID of the data provider for the user
     *
     * @return int
     */
    public function dataProviderId(): int
    {
        return $this->data_provider_id;
    }

    /**
     * Set the ID of the data provider
     *
     * @param int $dataProviderId
     */
    public function setDataProviderId(int $dataProviderId): void
    {
        $this->data_provider_id = $dataProviderId;
        $this->save();
    }

    /**
     * Laravel integration for a data property
     *
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function getDataAttribute(): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return $this->data();
    }
}
