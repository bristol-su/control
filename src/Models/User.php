<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\Contracts\Models\User as UserContract;
use BristolSU\ControlDB\Traits\UserTrait;
use Database\Factories\UserFactory;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a user
 */
class User extends Model implements UserContract
{
    use SoftDeletes, HasFactory, UserTrait {
        setDataProviderId as baseSetDataProviderId;
    }

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
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

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
     * Laravel integration for a data property
     *
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function getDataAttribute(): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return $this->data();
    }

    public function setDataProviderId(int $dataProviderId): void
    {
        $this->baseSetDataProviderId($dataProviderId);
        $this->refresh();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new UserFactory();
    }
}
