<?php

namespace BristolSU\ControlDB\Export\Handler;

use BristolSU\ControlDB\Export\FormattedItem;
use Illuminate\Support\Str;

trait UsesCsv
{

    /**
     * @param array|FormattedItem[] $items
     * @return array
     */
    public function getHeaders($items)
    {
        $headers = [];
        foreach($items as $item) {
            foreach($item->getColumnNames() as $column) {
                if(!in_array($column, $headers)) {
                    $headers[] = $column;
                }
            }
        }
        return $headers;
    }

    /**
     * @param array|FormattedItem[] $items
     * @param null $headers
     * @param $defaultIfNull
     * @return array
     */
    public function getRows($items, $headers = null, $defaultIfNull = null)
    {
        $headers = $headers ?? $this->getHeaders($items);
        
        $rows = [];
        foreach($items as $item) {
            $row = [];
            foreach($headers as $header) {
                $row[] = $item->getItem($header, $defaultIfNull);
            }
            $rows[] = $row;
        }
        
        return $rows;
    }

    public function generateCsv($items, $defaultIfNull = null)
    {
        $csv = tmpfile();

        $headers = $this->getHeaders($items);
        
        fputcsv($csv, $this->getHeaders($items));

        foreach($this->getRows($items, $headers, $defaultIfNull) as $row) {
            fputcsv($csv, $row);
        }
        
        return $csv;
    }
    
}