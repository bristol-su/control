<?php

namespace BristolSU\ControlDB\Export\Handler;

use Symfony\Component\VarDumper\VarDumper;

class DumpHandler extends Handler
{

    /**
     * @inheritDoc
     */
    protected function save(array $items)
    {
        VarDumper::dump(collect($items)->toArray());
    }
}