<?php

namespace BristolSU\ControlDB\Models\Dummy;

use BristolSU\ControlDB\Contracts\Models\DataUser;
use BristolSU\ControlDB\Contracts\Models\User;
use DateTime;

class DataUserDummy implements DataUser
{
    protected ?int $id;

    protected ?string $firstName = 'N/A';

    protected ?string $lastName = 'N/A';

    protected ?string $email = 'N/A';

    protected ?string $preferredName = 'N/A';

    public function __construct(int $id = null)
    {
        $this->id = $id;
    }

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'first_name' => $this->firstName(),
            'last_name' => $this->lastName(),
            'email' => $this->email(),
            'dob' => $this->dob(),
            'preferred_name' => $this->preferredName()
        ];
    }

    public function id(): int
    {
        return $this->id ?? 0;
    }

    public function firstName(): ?string
    {
        return $this->firstName;
    }

    public function lastName(): ?string
    {
        return $this->lastName;
    }

    public function email(): ?string
    {
        return $this->email;
    }

    public function dob(): ?DateTime
    {
        return null;
    }

    public function preferredName(): ?string
    {
        return $this->preferredName;
    }

    public static function addProperty(string $key): void
    {
    }

    public static function getAdditionalAttributes(): array
    {
    }

    public function getAdditionalAttribute(string $key)
    {
    }

    public function setAdditionalAttribute(string $key, $value)
    {
    }

    public function saveAdditionalAttribute(string $key, $value)
    {
    }

    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function setDob(?DateTime $dob): void
    {
    }

    public function setPreferredName(?string $name): void
    {
        $this->preferredName = $name;
    }

    public function user(): ?User
    {
        return null;
    }
}