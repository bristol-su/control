<?php

namespace BristolSU\ControlDB\Export\Formatter\Role;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class SimpleRoleFormatter extends Formatter
{

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        $roleData = $formattedItem->original()->data();
        $formattedItem->addRow('Role ID', $formattedItem->original()->id());
        $formattedItem->addRow('Role Name', $roleData->roleName());
        $formattedItem->addRow('Role Email', $roleData->email());
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::ROLES;
    }
}