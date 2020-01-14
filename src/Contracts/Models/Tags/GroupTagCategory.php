<?php

namespace BristolSU\ControlDB\Contracts\Models\Tags;

use Illuminate\Support\Collection;

/**
 * Interface GroupTag
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface GroupTagCategory
{

    /**
     * ID of the tag category
     *
     * @return mixed
     */
    public function id();

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

    public function setName(string $name);

    public function setDescription(string $description);

    public function setReference(string $reference);
}
