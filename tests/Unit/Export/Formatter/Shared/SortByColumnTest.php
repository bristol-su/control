<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Formatter\Shared;

use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Shared\SortByColumn;
use BristolSU\Tests\ControlDB\TestCase;

class SortByColumnTest extends TestCase
{

    /** @test */
    public function it_returns_the_items_sorted_by_the_column_alphabetically_if_the_column_is_a_string(){
        $formatted1 = FormattedItem::create(factory(Role::class)->create());
        $formatted2 = FormattedItem::create(factory(Role::class)->create());
        $formatted3 = FormattedItem::create(factory(Role::class)->create());
        $formatted1->addRow('col', 'Alpha');
        $formatted2->addRow('col', 'Charlie');
        $formatted3->addRow('col', 'Beta');
        
        $formatter = new SortByColumn(['column' => 'col']);
        $items = $formatter->format([$formatted1, $formatted2, $formatted3]);
        
        $this->assertCount(3, $items);
        $this->assertEquals($formatted1, $items[0]);
        $this->assertEquals($formatted3, $items[1]);
        $this->assertEquals($formatted2, $items[2]);
    }
    
    /** @test */
    public function it_returns_the_items_sorted_by_number_if_the_column_is_an_integer(){
        $formatted1 = FormattedItem::create(factory(Role::class)->create());
        $formatted2 = FormattedItem::create(factory(Role::class)->create());
        $formatted3 = FormattedItem::create(factory(Role::class)->create());
        $formatted1->addRow('col', 5000);
        $formatted2->addRow('col', 300);
        $formatted3->addRow('col', 500);

        $formatter = new SortByColumn(['column' => 'col']);
        $items = $formatter->format([$formatted1, $formatted2, $formatted3]);

        $this->assertCount(3, $items);
        $this->assertEquals($formatted2, $items[0]);
        $this->assertEquals($formatted3, $items[1]);
        $this->assertEquals($formatted1, $items[2]);
    }
    
    /** @test */
    public function null_values_appear_last(){
        $formatted1 = FormattedItem::create(factory(Role::class)->create());
        $formatted2 = FormattedItem::create(factory(Role::class)->create());
        $formatted3 = FormattedItem::create(factory(Role::class)->create());
        $formatted4 = FormattedItem::create(factory(Role::class)->create());
        $formatted1->addRow('col', 5000);
        $formatted2->addRow('col', 300);
        $formatted3->addRow('col', 500);

        $formatter = new SortByColumn(['column' => 'col']);
        $items = $formatter->format([$formatted1, $formatted2, $formatted3, $formatted4]);

        $this->assertCount(4, $items);
        $this->assertEquals($formatted2, $items[0]);
        $this->assertEquals($formatted3, $items[1]);
        $this->assertEquals($formatted1, $items[2]);
        $this->assertEquals($formatted4, $items[3]);
    }
    
}