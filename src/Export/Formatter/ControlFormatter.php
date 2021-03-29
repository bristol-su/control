<?php

namespace BristolSU\Support\Export\Formatter;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Role;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTag;
use BristolSU\ControlDB\Contracts\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTag;
use BristolSU\ControlDB\Contracts\Models\Tags\RoleTagCategory;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Models\Tags\UserTagCategory;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Export\FormattedItem;

abstract class Formatter
{

    public const USERS = User::class;

    public const GROUPS = Group::class;

    public const ROLES = Role::class;

    public const POSITIONS = Position::class;

    public const USERTAGS = UserTag::class;

    public const GROUPTAGS = GroupTag::class;

    public const ROLETAGS = RoleTag::class;

    public const POSITIONTAGS = PositionTag::class;

    public const USERTAGCATEGORIES = UserTagCategory::class;

    public const GROUPTAGCATEGORIES = GroupTagCategory::class;

    public const ROLETAGCATEGORIES = RoleTagCategory::class;

    public const POSITIONTAGCATEGORIES = PositionTagCategory::class;

    public const ALL = 'all';
    /**
     * @var array
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $key
     * @param null $default
     *
     * @return mixed|null
     */
    protected function config(string $key, $default = null)
    {
        if(array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        return $default;
    }

    /**
     * @param array|FormattedItem[] $items Items ready to format
     * @return array
     */
    public function format($items)
    {
        return array_map(function($item) {
            return $this->canHandle($item) ? $this->formatItem($item) : $item;
        }, $items);
    }

    abstract public function formatItem(FormattedItem $formattedItem): FormattedItem;

    abstract public function handles(): string;

    protected function canHandle(FormattedItem $item): bool
    {
        if($this->handles() === self::ALL) {
            return true;
        }
        return $item->isType($this->handles());
    }

}
