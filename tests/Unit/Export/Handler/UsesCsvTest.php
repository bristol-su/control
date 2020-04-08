<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Handler;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Handler\UsesCsv;
use BristolSU\Tests\ControlDB\TestCase;

class UsesCsvTest extends TestCase
{
    use UsesCsv;
    
    /** @test */
    public function getHeaders_returns_all_available_headers(){
        $formattedItem1 = FormattedItem::create('');
        $formattedItem1->addRow('Col1', 'Val1');
        $formattedItem1->addRow('Col2', 'Val2');
        $formattedItem2 = FormattedItem::create('');
        $formattedItem2->addRow('Col2', 'Val3');
        $formattedItem2->addRow('Col3', 'Val4');
        $formattedItem3 = FormattedItem::create('');
        $formattedItem3->addRow('Col1', 'Val5');
        $formattedItem3->addRow('Col4', 'Val6');
        
        $items = [
            $formattedItem1,
            $formattedItem2,
            $formattedItem3,
        ];
        
        $this->assertEquals([
            'Col1', 'Col2', 'Col3', 'Col4'
        ], $this->getHeaders($items));
    }
    
    /** @test */
    public function getRows_returns_rows_for_the_headers(){
        $formattedItem1 = FormattedItem::create('');
        $formattedItem1->addRow('Col1', 'Val1');
        $formattedItem1->addRow('Col2', 'Val2');
        $formattedItem2 = FormattedItem::create('');
        $formattedItem2->addRow('Col2', 'Val3');
        $formattedItem2->addRow('Col3', 'Val4');
        $formattedItem3 = FormattedItem::create('');
        $formattedItem3->addRow('Col1', 'Val5');
        $formattedItem3->addRow('Col4', 'Val6');

        $items = [
            $formattedItem1,
            $formattedItem2,
            $formattedItem3,
        ];

        $this->assertEquals([
            ['Val1', 'Val2', null],
            [null, 'Val3', 'Val4'],
            ['Val5', null, null],
        ], $this->getRows($items, ['Col1', 'Col2', 'Col3']));
    }
    
    /** @test */
    public function headers_are_calculated_if_not_given(){
        $formattedItem1 = FormattedItem::create('');
        $formattedItem1->addRow('Col1', 'Val1');
        $formattedItem1->addRow('Col2', 'Val2');
        $formattedItem2 = FormattedItem::create('');
        $formattedItem2->addRow('Col2', 'Val3');
        $formattedItem2->addRow('Col3', 'Val4');
        $formattedItem3 = FormattedItem::create('');
        $formattedItem3->addRow('Col1', 'Val5');
        $formattedItem3->addRow('Col4', 'Val6');

        $items = [
            $formattedItem1,
            $formattedItem2,
            $formattedItem3,
        ];

        $this->assertEquals([
            ['Val1', 'Val2', null, null],
            [null, 'Val3', 'Val4', null],
            ['Val5', null, null, 'Val6'],
        ], $this->getRows($items));
    }
    
    /** @test */
    public function a_default_can_be_set(){
        $formattedItem1 = FormattedItem::create('');
        $formattedItem1->addRow('Col1', 'Val1');
        $formattedItem1->addRow('Col2', 'Val2');
        $formattedItem2 = FormattedItem::create('');
        $formattedItem2->addRow('Col2', 'Val3');
        $formattedItem2->addRow('Col3', 'Val4');
        $formattedItem3 = FormattedItem::create('');
        $formattedItem3->addRow('Col1', 'Val5');
        $formattedItem3->addRow('Col4', 'Val6');

        $items = [
            $formattedItem1,
            $formattedItem2,
            $formattedItem3,
        ];

        $this->assertEquals([
            ['Val1', 'Val2', 'N/A', 'N/A'],
            ['N/A', 'Val3', 'Val4', 'N/A'],
            ['Val5', 'N/A', 'N/A', 'Val6'],
        ], $this->getRows($items, null, 'N/A'));
    }
    
    /** @test */
    public function generateCsv_creates_a_csv_with_the_correct_content(){
        $formattedItem1 = FormattedItem::create('');
        $formattedItem1->addRow('Col1', 'Val1');
        $formattedItem1->addRow('Col2', 'Val2');
        $formattedItem2 = FormattedItem::create('');
        $formattedItem2->addRow('Col2', 'Val3');
        $formattedItem2->addRow('Col3', 'Val 4');
        $formattedItem3 = FormattedItem::create('');
        $formattedItem3->addRow('Col1', 'Val5');
        $formattedItem3->addRow('Col4', 'Val6');

        $items = [
            $formattedItem1,
            $formattedItem2,
            $formattedItem3,
        ];

        $csv = $this->generateCsv($items, 'N/A');
        rewind($csv);
        $contents = stream_get_contents($csv);
        $this->assertEquals('Col1,Col2,Col3,Col4
Val1,Val2,N/A,N/A
N/A,Val3,"Val 4",N/A
Val5,N/A,N/A,Val6
', $contents);
    }
    
}