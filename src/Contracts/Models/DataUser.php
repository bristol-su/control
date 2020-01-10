<?php


namespace BristolSU\ControlDB\Contracts\Models;


use DateTime;

interface DataUser
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

    public function id();

}