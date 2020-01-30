<?php


namespace BristolSU\ControlDB\Contracts\Models;


use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Represents a position
 */
interface Position extends Arrayable, Jsonable
{

    /**
     * ID of the position
     *
     * @return int
     */
    public function id(): int;

    /**
     * The ID of the data provider
     * @return int
     */
    public function dataProviderId(): int;

    /**
     * Set the data provider ID
     *
     * @param int $dataProviderId
     */
    public function setDataProviderId(int $dataProviderId): void;

    /**
     * The data attributes of the position
     * 
     * @return DataPosition
     */
    public function data(): DataPosition;

    /**
     * Roles with this position
     *
     * @return Collection
     */
    public function roles(): Collection;

    /**
     * Tags the position is tagged with
     *
     * @return Collection
     */
    public function tags(): Collection;

    /**
     * Add a tag to the position
     * 
     * @param PositionTag $roleTag
     */
    public function addTag(PositionTag $roleTag): void;

    /**
     * Remove a tag from the position
     * 
     * @param PositionTag $roleTag
     */
    public function removeTag(PositionTag $roleTag): void;


}
