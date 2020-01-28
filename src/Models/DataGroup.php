<?php

namespace BristolSU\ControlDB\Models;

use BristolSU\ControlDB\AdditionalProperties\HasAdditionalProperties;
use BristolSU\ControlDB\Traits\DataGroupTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a data group, information to attach to a group such as a name
 */
class DataGroup extends Model implements \BristolSU\ControlDB\Contracts\Models\DataGroup
{
    use SoftDeletes, HasAdditionalProperties, DataGroupTrait;

    /**
     * Defines the table we use
     * 
     * @var string 
     */
    protected $table = 'control_data_group';

    /**
     * Defines the fillable properties of the model
     * 
     * @var array 
     */
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * Gets the ID of the group
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Sets the name of the group
     * 
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
        $this->save();
    }

    /**
     * Sets the email of the group
     * 
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
        $this->save();
    }

    /**
     * Gets the name of the group
     * 
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * Gets the email of the group
     * 
     * @return string|null
     */
    public function email(): ?string
    {
        return $this->email;
    }
    
}