<?php

namespace BristolSU\ControlDB\Export\Formatter\Role;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class AddRoleHoldersAsNewItems extends Formatter
{

    public function format($items)
    {
        $newItems = [];
        foreach($items as $item) {
            foreach($item->original()->users() as $user) {
                $newItem = clone $item;
                $dataUser = $user->data();
                $newItem->addRow('User ID', $user->id());
                $newItem->addRow('User First Name', $dataUser->firstName());
                $newItem->addRow('User Last Name', $dataUser->lastName());
                $newItem->addRow('User Preferred Name', $dataUser->preferredName());
                $newItem->addRow('User Email', $dataUser->email());
                $newItems[] = $newItem;
            }
        }
        return $newItems;
    }

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::ROLES;
    }
}