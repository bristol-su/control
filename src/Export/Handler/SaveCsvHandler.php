<?php

namespace BristolSU\ControlDB\Export\Handler;

use Illuminate\Support\Facades\Storage;

class SaveCsvHandler extends Handler
{
    use UsesCsv;
    
    /**
     * @inheritDoc
     */
    protected function save(array $items)
    {
        $csv = $this->generateCsv($items, $this->config('defaultIfNull', 'N/A'));
        
        Storage::disk($this->config('disk', null))
            ->put($this->config('filename', 'export.csv'), $csv);
    }
}