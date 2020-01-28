<?php


namespace BristolSU\ControlDB\Contracts\Models;


use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

/**
 * Interface Position
 * @package BristolSU\ControlDB\Contracts\Models
 */
interface Position extends Arrayable, Jsonable
{

    public function data(): DataPosition;

    public function dataProviderId(): int;
    
    /**
     * ID of the position
     *
     * @return int
     */
    public function id(): int;

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

    public function setDataProviderId(int $dataProviderId): void;

    public function addTag(PositionTag $roleTag): void;

    public function removeTag(PositionTag $roleTag): void;


}
