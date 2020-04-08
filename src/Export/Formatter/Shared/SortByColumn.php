<?php

namespace BristolSU\ControlDB\Export\Formatter\Shared;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;

class SortByColumn extends Formatter
{

    public function format($items)
    {
        $column = $this->config('column', 'id');
        
        usort($items, function($a, $b) use ($column) {
            $aVal = $a->getItem($column);
            $bVal = $b->getItem($column);
            if(is_null($aVal) && is_null($bVal)) {
                return 0;
            }
            if(is_null($aVal) && !is_null($bVal)) {
                return 1;
            }
            if(!is_null($aVal) && is_null($bVal)) {
                return -1;
            }
            if(is_string($aVal) || is_string($bVal)) {
                return $this->compareStrings($aVal, $bVal);
            }
            if(is_int($aVal) || is_int($bVal)) {
                return $this->compareInts($aVal, $bVal);
            }
            return 0;
        });
        return $items;
    }
    
    private function compareStrings(string $a, string $b): int 
    {
        return strcmp($a, $b);
    }

    public function compareInts(int $a, int $b): int
    {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }
 
    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::ALL;
    }
}