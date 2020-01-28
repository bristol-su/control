<?php


namespace BristolSU\ControlDB\Contracts\Models;


use BristolSU\ControlDB\AdditionalProperties\ImplementsAdditionalProperties;
use DateTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

interface DataUser extends ImplementsAdditionalProperties, Arrayable, Jsonable
{

    public function setFirstName(?string $firstName): void;

    public function setLastName(?string $lastName): void;
    
    public function setEmail(?string $email): void;
    
    public function setDob(?DateTime $dob): void;
    
    public function setPreferredName(?string $name): void;

    public function firstName(): ?string;

    public function lastName(): ?string;

    public function email(): ?string;

    public function dob(): ?DateTime;

    public function preferredName(): ?string;

    public function id(): int;

    public function user(): ?User;

}