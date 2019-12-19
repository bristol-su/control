<?php


namespace BristolSU\ControlDB\Contracts\Models\Tags;


use Illuminate\Support\Collection;

/**
 * Interface PositionTag
 * @package BristolSU\ControlDB\Contracts\Models
 */
abstract class PositionTag
{

    /**
     * ID of the position tag
     *
     * @return int
     */
    abstract public function id(): int;

    /**
     * Name of the tag
     *
     * @return string
     */
    abstract public function name(): string;

    /**
     * Description of the tag
     *
     * @return string
     */
    abstract public function description(): string;

    /**
     * Reference of the tag
     *
     * @return string
     */
    abstract public function reference(): string;

    /**
     * ID of the tag category
     * @return int
     */
    abstract public function categoryId(): int;

    /**
     * Tag Category
     *
     * @return PositionTagCategory
     */
    public function category(): PositionTagCategory
    {

    }

    /**
     * Full reference of the tag
     *
     * This should be the tag category reference and the tag reference, separated with a period.
     * @return string
     */
    public function fullReference(): string
    {

    }

    /**
     * Positions that have this tag
     *
     * @return Collection
     */
    public function positions(): Collection
    {

    }
}
