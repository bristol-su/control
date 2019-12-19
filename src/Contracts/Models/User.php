<?php


namespace BristolSU\ControlDB\Contracts\Models;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

/**
 * Interface User
 * @package BristolSU\ControlDB\Contracts\Models
 */
abstract class User extends Authenticatable
{

    /**
     * ID of the user
     *
     * @return mixed
     */
    abstract public function id();

    abstract public function forename(): string;

    abstract public function surname(): string;

    abstract public function email(): ?string;

    /**
     * Tags the user is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection;

    /**
     * Roles the user owns
     *
     * @return Collection
     */
    public function roles(): Collection;

    /**
     * Groups the user is a member of
     *
     * @return Collection
     */
    public function groups(): Collection;
}
