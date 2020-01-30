<?php

namespace BristolSU\ControlDB\Contracts\Models;

use BristolSU\ControlDB\AdditionalProperties\ImplementsAdditionalProperties;
use DateTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Handles attributes about a user
 */
interface DataUser extends ImplementsAdditionalProperties, Arrayable, Jsonable
{

    /**
     * Get the ID of the data user
     * 
     * @return int
     */
    public function id(): int;

    /**
     * Get the first name of the data user
     * 
     * @return string|null
     */
    public function firstName(): ?string;

    /**
     * Get the last name of the user
     * 
     * @return string|null
     */
    public function lastName(): ?string;

    /**
     * Get the email of the user
     * @return string|null
     */
    public function email(): ?string;

    /**
     * Get the date of birth of the user
     * 
     * @return DateTime|null
     */
    public function dob(): ?DateTime;

    /**
     * Get the preferred name of the user
     * 
     * @return string|null
     */
    public function preferredName(): ?string;

    /**
     * Set the first name of the user
     * 
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void;

    /**
     * Set the last name of the user
     * 
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void;

    /**
     * Set the email of the user
     * 
     * @param string|null $email
     */
    public function setEmail(?string $email): void;

    /**
     * Set the date of birth of the user
     * 
     * @param DateTime|null $dob
     */
    public function setDob(?DateTime $dob): void;

    /**
     * Set the preferred name of the user
     * 
     * @param string|null $name
     */
    public function setPreferredName(?string $name): void;

    /**
     * Get the user using this data user
     * 
     * @return User|null
     */
    public function user(): ?User;

}