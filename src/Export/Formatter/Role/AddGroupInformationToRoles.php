<?php

namespace BristolSU\ControlDB\Export\Formatter\Role;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class AddGroupInformationToRoles extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        $group = $formattedItem->original()->group();
        $dataGroup = $group->data();
        $formattedItem->addRow('Group ID', $group->id());
        $formattedItem->addRow('Group Name', $dataGroup->name());
        $formattedItem->addRow('Group Email', $dataGroup->email());
        return  $formattedItem;
    }

    public function handles(): string
    {
        return static::ROLES;
    }
}