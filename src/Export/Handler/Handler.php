<?php

namespace BristolSU\ControlDB\Export\Handler;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

abstract class Handler
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Prepare items by transforming them to formattable items
     *
     * @param $items
     * @return FormattedItem[]
     */
    protected function prepareItems($items)
    {
        $formattedItems = [];
        foreach($items as $item) {
            $formattedItems[] = FormattedItem::create($item);
        }
        return $formattedItems;
    }

    public function export($items = [])
    {
        if($items instanceof Collection) {
            $items = $items->all();
        }
        $formattedItems = $this->prepareItems($items);
        foreach($this->getFormatters() as $formatter) {
            $time=-hrtime(true);
            $formattedItems = $formatter->format($formattedItems);
            $time+=hrtime(true);
            $this->logTime(class_basename($formatter), $time / 1e+9);
        }
        $this->save($formattedItems);
    }

    /**
     * @return Formatter[]
     */
    protected function getFormatters()
    {
        return array_map(function($className) {
            if(class_exists($className)) {
                return new $className($this->config('formatters')[$className]);
            }
            throw new \Exception(sprintf('Formatter %s does not exist', $className));
        }, array_keys($this->config('formatters', [])));
    }

    /**
     * @param FormattedItem[] $items
     * @return mixed
     */
    abstract protected function save(array $items);

    /**
     * @param string $key
     * @param null $default
     *
     * @return mixed|null
     */
    protected function config(string $key, $default = null)
    {
        if(array_key_exists($key, $this->config)) {
            return $this->config[$key];
        }
        return $default;
    }

    private function logTime(string $formatter, float $time)
    {
        if(config('control.log-formatters')) {
            Log::info(sprintf('Formatter [%s] took %.2f s to run', $formatter, $time));
        }
    }
}
