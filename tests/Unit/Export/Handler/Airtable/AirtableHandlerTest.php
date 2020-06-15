<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Handler\Airtable;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Handler\Airtable\AirtableHandler;
use BristolSU\ControlDB\Export\Handler\Airtable\CreateRows;
use BristolSU\ControlDB\Export\Handler\Airtable\DeleteRows;
use BristolSU\ControlDB\Export\Handler\Airtable\IdRetriever;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Bus;

class AirtableHandlerTest extends TestCase
{

    /** @test */
    public function it_fires_a_delete_rows_for_every_row_in_the_cache(){
        Bus::fake(DeleteRows::class);
        $idRetriever = app(IdRetriever::class, [
            'baseId' => 'baseId123',
            'tableName' => 'tableName123'
        ]);
        $idRetriever->saveIds(['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l']);
        
        $handler = new AirtableHandler([
            'baseId' => 'baseId123',
            'tableName' => 'tableName123',
            'apiKey' => 'apiKey123'
        ]);
        $handler->export([]);
        
        Bus::assertDispatched(DeleteRows::class, function($job) {
            $reflectionClass = new \ReflectionClass(DeleteRows::class);
            $dataProp = $reflectionClass->getProperty('data');
            $dataProp->setAccessible(true);
            $data = $dataProp->getValue($job);
            
            return $data === [
                'records' => [
                    'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'
                ]
            ];
        });

        Bus::assertDispatched(DeleteRows::class, function($job) {
            $reflectionClass = new \ReflectionClass(DeleteRows::class);
            $dataProp = $reflectionClass->getProperty('data');
            $dataProp->setAccessible(true);
            $data = $dataProp->getValue($job);

            return $data === [
                'records' => [
                    'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'
                ]
            ];
        });
        
    }
    
    /** @test */
    public function it_fires_a_create_rows_for_every_row_in_the_cache(){
        Bus::fake(CreateRows::class);
        
        $item1 = new FormattedItem(factory(Group::class)->create());
        $item2 = new FormattedItem(factory(Group::class)->create());
        
        $handler = new AirtableHandler([
            'baseId' => 'baseId123',
            'tableName' => 'tableName123',
            'apiKey' => 'apiKey123'
        ]);
        $handler->export([$item1, $item2]);
        
        Bus::assertDispatched(CreateRows::class);
        
    }
    
    
    
}