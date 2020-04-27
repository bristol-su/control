<?php


namespace BristolSU\ControlDB\Models;


use BristolSU\ControlDB\AdditionalProperties\HasAdditionalProperties;
use BristolSU\ControlDB\Traits\DataUserTrait;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Handles attributes belonging to a user
 */
class DataUser extends Model implements \BristolSU\ControlDB\Contracts\Models\DataUser
{
    use SoftDeletes, HasAdditionalProperties, DataUserTrait {
        setFirstName as baseSetFirstName;
        setLastName as baseSetLastName;
        setEmail as baseSetEmail;
        setDob as baseSetDob;
        setPreferredName as baseSetPreferredName;
    }

    /**
     * The table to use
     * 
     * @var string 
     */
    protected $table = 'control_data_user';

    /**
     * Attributes that are fillable
     * 
     * @var array 
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'dob', 'preferred_name'
    ];

    /**
     * Casted attributes
     * 
     * @var array 
     */
    protected $casts = [
        'dob' => 'datetime'
    ];
    
    /**
     * Get the ID of the user
     * 
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Get the first name for the user
     * 
     * @return string|null
     */
    public function firstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * Get the last name for the user
     * 
     * @return string|null
     */
    public function lastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * Get the email for the user
     * 
     * @return string|null
     */
    public function email(): ?string
    {
        return $this->email;
    }

    /**
     * Get the date of birth for the user
     * 
     * @return DateTime|null
     */
    public function dob(): ?DateTime
    {
        return $this->dob;
    }

    /**
     * Get the preferred name for the user
     * 
     * @return string|null
     */
    public function preferredName(): ?string
    {
        return $this->preferred_name;
    }

    /**
     * Set the users first name
     *
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        $this->baseSetFirstName($firstName);
        $this->refresh();
    }

    /**
     * Set the users last name
     *
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        $this->baseSetLastName($lastName);
        $this->refresh();
    }

    /**
     * Set the users email
     *
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->baseSetEmail($email);
        $this->refresh();
    }

    /**
     * Set the date of birth attribute
     *
     * @param DateTime|null $dob
     */
    public function setDob(?DateTime $dob): void
    {
        $this->baseSetDob($dob);
        $this->refresh();
    }

    /**
     * Set the preferred name for the user
     *
     * @param string|null $name
     */
    public function setPreferredName(?string $name): void
    {
        $this->baseSetPreferredName($name);
        $this->refresh();
    }


}
