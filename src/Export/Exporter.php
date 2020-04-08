<?php

namespace BristolSU\ControlDB\Export;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void export($items = [])
 * @method static ExportManager withFormatter(string $formatterClass, array $config = [])
 * 
 * @see ExportManager
 */
class Exporter extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'control-exporter';
    }
    
}