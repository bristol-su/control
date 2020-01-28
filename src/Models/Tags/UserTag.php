<?php


namespace BristolSU\ControlDB\Models\Tags;


use BristolSU\ControlDB\Scopes\UserTagScope;
use BristolSU\ControlDB\Traits\Tags\UserTagTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserTag
 * @package BristolSU\ControlDB\Models
 */
class UserTag extends Model implements \BristolSU\ControlDB\Contracts\Models\Tags\UserTag
{

    use SoftDeletes, UserTagTrait;

    protected $table = 'control_tags';

    protected $fillable = [
        'name', 'description', 'reference', 'tag_category_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new UserTagScope());
    }

    /**
     * ID of the user tag
     *
     * @return int
     */
    public function id(): int
    {
        return $this->id;
    }

    /**
     * Name of the tag
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * Description of the tag
     *
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * Reference of the tag
     *
     * @return string
     */
    public function reference(): string
    {
        return $this->reference;
    }

    /**
     * ID of the tag category
     * @return int
     */
    public function categoryId(): int
    {
        return $this->tag_category_id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
        $this->save();
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
        $this->save();
    }

    public function setReference(string $reference): void
    {
        $this->reference = $reference;
        $this->save();
    }

    public function setTagCategoryId($categoryId): void
    {
        $this->category_id = $categoryId;
        $this->save();
    }
}
