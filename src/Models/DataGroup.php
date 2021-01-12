<?php

namespace BristolSU\ControlDB\Models;

use BristolSU\ControlDB\AdditionalProperties\HasAdditionalProperties;
use BristolSU\ControlDB\Traits\DataGroupTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Represents a data group, information to attach to a group such as a name
 */
class DataGroup extends Model implements \BristolSU\ControlDB\Contracts\Models\DataGroup
{
    use SoftDeletes, HasAdditionalProperties, DataGroupTrait {
        setName as baseSetName;
        setEmail as baseSetEmail;
    }

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
     * Gets the ID of the group
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
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

    /**
     * Set the name of the group
     *
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->baseSetName($name);
        $this->refresh();
    }

    /**
     * Set the email of the group
     *
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->baseSetEmail($email);
        $this->refresh();

    }


}
