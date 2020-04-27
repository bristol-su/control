<?php

namespace BristolSU\ControlDB\Export\Formatter\Group;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class SimpleGroupFormatter extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        $groupData = $formattedItem->original()->data();
        $formattedItem->addRow('Group ID', $formattedItem->original()->id());
        $formattedItem->addRow('Group Name', $groupData->name());
        $formattedItem->addRow('Group Email', $groupData->email());    
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::GROUPS;
    }
}