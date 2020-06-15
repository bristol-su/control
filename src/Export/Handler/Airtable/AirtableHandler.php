<?php


namespace BristolSU\ControlDB\Export\Handler\Airtable;


use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Handler\Handler;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AirtableHandler extends Handler
{

    /**
     * Save each item to AirTable
     * 
     * @param FormattedItem[] $items
     * @return mixed|void
     */
    protected function save(array $items)
    {
        $creating = [];
        
        foreach($items as $item) {
            $creating[] = [
                'fields' => $item->toArray()
            ];
        }
        
        $time = Carbon::now();
        $time = $this->clearTable($time);
        $this->createRows($creating, $time);
    }

    protected function createRows($creating, $time)
    {
        foreach (collect($creating)->chunk(10) as $fields) {
            dispatch(
                new CreateRows(['records' => $fields->values()->toArray(), 'typecast' => true], $this->config('apiKey'),
                    $this->config('baseId'), $this->config('tableName'))
            )->delay($time);
            $time->addSeconds(2);
        }
    }

    protected function clearTable($time)
    {
        $idRetriever = app(IdRetriever::class, [
            'baseId' => $this->config('baseId'),
            'tableName' => $this->config('tableName')
        ]);
        $ids = $idRetriever->ids();

        foreach ($ids->chunk(10) as $idsToRemove) {
            dispatch(
                new DeleteRows(['records' => $idsToRemove->values()->toArray()],
                    $this->config('apiKey'), $this->config('baseId'),
                    $this->config('tableName'))
            )->delay($time);
            $time->addSeconds(2);
        }
        $idRetriever->saveIds([]);
        return $time;
    }


}