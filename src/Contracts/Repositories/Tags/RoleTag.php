<?php


namespace BristolSU\ControlDB\Contracts\Repositories\Tags;

use BristolSU\ControlDB\Contracts\Models\Role as RoleContract;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory as RoleTagCategoryContract;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag as RoleTagModel;
use Illuminate\Support\Collection;

/**
 * Interface RoleTag
 * @package BristolSU\ControlDB\Contracts\Repositories
 */
interface RoleTag
{

    /**
     * Get all role tags
     *
     * @return Collection
     */
    public function all(): Collection;
    
    /**
     * Get a tag by the full reference
     *
     * @param $reference
     * @return mixed
     */
    public function getTagByFullReference(string $reference): RoleTagModel;

    /**
     * Get a role tag by id
     *
     * @param int $id
     * @return RoleTagModel
     */
    public function getById(int $id): RoleTagModel;

    public function create(string $name, string $description, string $reference, $tagCategoryId): RoleTagModel;

    public function delete(int $id): void;
}
