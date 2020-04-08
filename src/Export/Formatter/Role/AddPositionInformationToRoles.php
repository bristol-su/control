<?php

namespace BristolSU\ControlDB\Export\Formatter\Role;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class AddPositionInformationToRoles extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        $position = $formattedItem->original()->position();
        $dataPosition = $position->data();
        $formattedItem->addRow('Position ID', $position->id());
        $formattedItem->addRow('Position Name', $dataPosition->name());
        return  $formattedItem;
    }

    public function handles(): string
    {
        return static::ROLES;
    }
}