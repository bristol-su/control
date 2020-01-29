<?php

namespace BristolSU\ControlDB\Models;

use BristolSU\ControlDB\AdditionalProperties\HasAdditionalProperties;
use BristolSU\ControlDB\Traits\DataGroupTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataGroup extends Model implements \BristolSU\ControlDB\Contracts\Models\DataGroup
{
    use SoftDeletes, HasAdditionalProperties, DataGroupTrait;

    /**
     * Define the table to use
     * 
     * @var string 
     */
    protected $table = 'control_data_group';

    /**
     * Define fillable attributes
     * 
     * @var array 
     */
    protected $fillable = [
        'name', 'email'
    ];

    /**
     * Get the ID of the group
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Get the name of the group
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->name;
    }

    /**
     * Get the email of the group
     *
     * @return string|null
     */
    public function email(): ?string
    {
        return $this->email;
    }

    /**
     * Set the name of the group
     *
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
        $this->save();
    }

    /**
     * Set the email of the group
     *
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
        $this->save();
    }
}