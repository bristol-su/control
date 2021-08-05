<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\AdditionalProperties\HasAdditionalProperties;
use BristolSU\ControlDB\Traits\DataRoleTrait;
use DateTime;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Handles attributes belonging to a role
 */
class DataRole extends Model implements \BristolSU\ControlDB\Contracts\Models\DataRole
{
    use SoftDeletes, HasAdditionalProperties, DataRoleTrait {
        setRoleName as baseSetRoleName;
        setEmail as baseSetEmail;
    }

    /**
     * The table to use
     *
     * @var string
     */
    protected $table = 'control_data_role';

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [
        'role_name', 'email'
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
     * Get the ID of the role
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }



    /**
     * Get the email of the role
     *
     * @return string|null
     */
    public function email(): ?string
    {
        return $this->email;
    }

    /**
     * Get the name for the role
     *
     * @return string|null
     */
    public function roleName(): ?string
    {
        return $this->role_name;
    }

    /**
     * Set the email of the role
     *
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->baseSetEmail($email);
        $this->refresh();
    }

    /**
     * Set a name for the role
     *
     * @param string|null $roleName
     */
    public function setRoleName(?string $roleName): void
    {
        $this->baseSetRoleName($roleName);
        $this->refresh();
    }


}
