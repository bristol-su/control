<?php

namespace BristolSU\ControlDB\Contracts\Models\Tags;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Interface UserTag
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface UserTagCategory extends Arrayable, Jsonable
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

    public function setName(string $name): void;

    public function setDescription(string $description): void;

    public function setReference(string $reference): void;
    
    
}
