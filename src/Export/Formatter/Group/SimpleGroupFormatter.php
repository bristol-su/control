<?php

namespace BristolSU\ControlDB\Export\Formatter\Group;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class SimpleGroupFormatter extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        $formattedItem->addRow('Group ID', $formattedItem->original()->id());
        $formattedItem->addRow('Group Name', $formattedItem->original()->data()->name());
        $formattedItem->addRow('Group Email', $formattedItem->original()->data()->email());    
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::GROUPS;
    }
}