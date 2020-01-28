<?php

namespace BristolSU\ControlDB\Contracts\Models\Tags;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Represents a role tag category
 */
interface RoleTagCategory extends Arrayable, Jsonable
{

    /**
     * ID of the tag category
     *
     * @return mixed
     */
    public function id(): int;

    /**
     * Name of the tag category
     *
     * @return string
     */
    public function name(): string;

    /**
     * Deacription of the tag category
     *
     * @return string
     */
    public function description(): string;

    /**
     * Reference of the tag category
     *
     * @return string
     */
    public function reference(): string;

    /**
     * All tags under this tag category
     *
     * @return Collection
     */
    public function tags(): Collection;

    /**
     * Set the name of the role tag category
     *
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * Set a description for the role tag category
     *
     * @param string $description
     */
    public function setDescription(string $description): void;

    /**
     * Set a reference for a role tag category
     *
     * @param string $reference
     */
    public function setReference(string $reference): void;
}
