<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Handler;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;
use BristolSU\ControlDB\Export\Handler\SaveCsvHandler;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\Storage;

class SaveCsvHandlerTest extends TestCase
{

    /** @test */
    public function save_saves_a_csv_file(){
        Storage::fake();
        
        $formattedItem1 = FormattedItem::create('');
        $formattedItem1->addRow('Row1', 'Value 1');
        $formattedItem2 = FormattedItem::create('');
        $formattedItem2->addRow('Row2', 'Value 2');
        
        $items = [
            $formattedItem1, $formattedItem2
        ];
            
        $handler = new SaveCsvHandler([
            'formatters' => [TestFormatterForSaveCsv::class => ['items' => $items]],
            'filename' => 'export.csv'
        ]);
        
        $handler->export($items);
        
        Storage::assertExists('export.csv');
    }
    
    /** @test */
    public function the_filename_can_be_changed(){
        Storage::fake();

        $formattedItem1 = FormattedItem::create('');
        $formattedItem1->addRow('Row1', 'Value 1');
        $formattedItem2 = FormattedItem::create('');
        $formattedItem2->addRow('Row2', 'Value 2');

        $items = [
            $formattedItem1, $formattedItem2
        ];

        $handler = new SaveCsvHandler([
            'formatters' => [TestFormatterForSaveCsv::class => ['items' => $items]],
            'filename' => 'export2.csv'
        ]);

        $handler->export($items);

        Storage::assertExists('export2.csv');
    }

    /** @test */
    public function the_disk_can_be_changed(){
        Storage::fake('diskToFake');

        $formattedItem1 = FormattedItem::create('');
        $formattedItem1->addRow('Row1', 'Value 1');
        $formattedItem2 = FormattedItem::create('');
        $formattedItem2->addRow('Row2', 'Value 2');

        $items = [
            $formattedItem1, $formattedItem2
        ];

        $handler = new SaveCsvHandler([
            'formatters' => [TestFormatterForSaveCsv::class => ['items' => $items]],
            'filename' => 'export2.csv',
            'disk' => 'diskToFake'
        ]);

        $handler->export($items);

        Storage::disk('diskToFake')->assertExists('export2.csv');
    }
    
    
    
}

class TestFormatterForSaveCsv extends Formatter
{
    
    public function format($items)
    {
        return $this->config('items', []);
    }

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        // TODO: Implement formatItem() method.
    }

    public function handles(): string
    {
        // TODO: Implement handles() method.
    }
}