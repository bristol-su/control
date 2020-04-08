<?php

namespace BristolSU\ControlDB\Export\Formatter\Role;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class SimpleRoleFormatter extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        $formattedItem->addRow('Role ID', $formattedItem->original()->id());
        $formattedItem->addRow('Role Name', $formattedItem->original()->data()->roleName());
        $formattedItem->addRow('Role Email', $formattedItem->original()->data()->email());
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::ROLES;
    }
}