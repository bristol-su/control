<?php

namespace BristolSU\ControlDB\Export\Formatter\User;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class SimpleUserFormatter extends Formatter
{

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        $dataUser = $formattedItem->original()->data();
        $formattedItem->addRow('User ID', $formattedItem->original()->id());
        $formattedItem->addRow('User First Name', $dataUser->firstName());
        $formattedItem->addRow('User Last Name', $dataUser->lastName());
        $formattedItem->addRow('User Preferred Name', $dataUser->preferredName());
        $formattedItem->addRow('User Email', $dataUser->email());
        $formattedItem->addRow('User DoB', $dataUser->dob());
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::USERS;
    }
}