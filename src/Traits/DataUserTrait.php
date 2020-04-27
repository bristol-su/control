<?php


namespace BristolSU\ControlDB\Traits;


use BristolSU\ControlDB\Contracts\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Implements methods to the data user interface using repositories
 */
trait DataUserTrait
{

    /**
     * Get the user using the data user
     *
     * @return User|null
     */
    public function user(): ?User
    {
        try {
            return app(\BristolSU\ControlDB\Contracts\Repositories\User::class)->getByDataProviderId($this->id());
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    /**
     * Set the users first name
     *
     * @param string|null $firstName
     */
    public function setFirstName(?string $firstName): void
    {
        app(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class)->update(
            $this->id(), $firstName, $this->lastName(), $this->email(), $this->dob(), $this->preferredName()
        );
    }

    /**
     * Set the users last name
     *
     * @param string|null $lastName
     */
    public function setLastName(?string $lastName): void
    {
        app(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class)->update(
            $this->id(), $this->firstName(), $lastName, $this->email(), $this->dob(), $this->preferredName()
        );
    }

    /**
     * Set the users email
     *
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        app(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class)->update(
            $this->id(), $this->firstName(), $this->lastName(), $email, $this->dob(), $this->preferredName()
        );
    }

    /**
     * Set the date of birth attribute
     *
     * @param DateTime|null $dob
     */
    public function setDob(?DateTime $dob): void
    {
        app(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class)->update(
            $this->id(), $this->firstName(), $this->lastName(), $this->email(), $dob, $this->preferredName()
        );
    }

    /**
     * Set the preferred name for the user
     *
     * @param string|null $name
     */
    public function setPreferredName(?string $name): void
    {
        app(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class)->update(
            $this->id(), $this->firstName(), $this->lastName(), $this->email(), $this->dob(), $name
        );
    }
}