<?php


namespace BristolSU\ControlDB\Contracts\Models;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;

/**
 * Interface User
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface User extends Authenticatable
{

    /**
     * ID of the user
     *
     * @return mixed
     */
    public function id();

    public function forename(): string;

    public function surname(): string;

    public function email(): ?string;

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
