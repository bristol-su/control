<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\AdditionalProperties\HasAdditionalProperties;
use BristolSU\ControlDB\Traits\DataRoleTrait;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Handles attributes belonging to a role
 */
class DataRole extends Model implements \BristolSU\ControlDB\Contracts\Models\DataRole
{
    use SoftDeletes, HasAdditionalProperties, DataRoleTrait;

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
     * Get the ID of the role
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Set the email of the role
     * 
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
        $this->save();
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
     * Set a name for the role
     * 
     * @param string|null $roleName
     */
    public function setRoleName(?string $roleName): void
    {
        $this->role_name = $roleName;
        $this->save();
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
}