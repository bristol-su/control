<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Formatter;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use PHPUnit\Framework\Assert;

class FormatterTest extends TestCase
{

    /** @test */
    public function it_calls_formatItem_if_the_formatted_item_matches_the_type(){
        $items = [
            FormattedItem::create(User::factory()->create()),
            FormattedItem::create(User::factory()->create()),
            FormattedItem::create(User::factory()->create()),
        ];
        
        $ids = array_map(function($item) {
            return $item->original()->id();
        }, $items);

        $called = 0;
        
        $formatter = new TestFormatter([]);
        $formatter->handlesShouldReturn(Formatter::USERS);
        $formatter->formatItemCallback(function($formattedItem) use ($ids, &$called) {
            Assert::assertContains($formattedItem->original()->id(), $ids);
            $called++;
            return $formattedItem;
        });
        $formatter->format($items);
        $this->assertEquals(3, $called);
    }
    
    /** @test */
    public function it_calls_formatItem_if_the_formatter_handles_all(){
        $items = [
            FormattedItem::create(User::factory()->create()),
            FormattedItem::create(User::factory()->create()),
            FormattedItem::create(User::factory()->create()),
        ];

        $ids = array_map(function($item) {
            return $item->original()->id();
        }, $items);

        $called = 0;
        
        $formatter = new TestFormatter([]);
        $formatter->handlesShouldReturn(Formatter::ALL);
        $formatter->formatItemCallback(function($formattedItem) use ($ids, &$called) {
            Assert::assertContains($formattedItem->original()->id(), $ids);
            $called++;
            return $formattedItem;
        });
        $newItems = $formatter->format($items);
        $this->assertEquals(3, $called);
    }
    
    /** @test */
    public function it_does_not_call_formatItem_if_the_formatter_cannot_handle_the_item(){
        $items = [
            FormattedItem::create(User::factory()->create()),
            FormattedItem::create(User::factory()->create()),
            FormattedItem::create(User::factory()->create()),
        ];

        $formatter = new TestFormatter([]);
        $formatter->handlesShouldReturn(Formatter::ROLES);
        $called = 0;
        $formatter->formatItemCallback(function($formattedItem) use (&$called) {
            Assert::assertFalse(true, 'The function should not have been called');
            $called++;
            return $formattedItem;
        });
        $newItems = $formatter->format($items);
        $this->assertEquals(0, $called);
    }
    
    /** @test */
    public function it_returns_the_formatted_items(){
        $items = [
            FormattedItem::create(User::factory()->create()),
            FormattedItem::create(User::factory()->create()),
            FormattedItem::create(User::factory()->create()),
        ];

        $ids = array_map(function($item) {
            return $item->original()->id();
        }, $items);
        
        $formatter = new TestFormatter([]);
        $formatter->handlesShouldReturn(Formatter::USERS);
        $formatter->formatItemCallback(function($formattedItem) use ($ids) {
            Assert::assertContains($formattedItem->original()->id(), $ids);
            $formattedItem->addRow('testrow', 'Val');
            return $formattedItem;
        });
        $newItems = $formatter->format($items);
        foreach($newItems as $item) {
            $this->assertEquals(['testrow'], $item->getColumnNames());
        }
    }

    /** @test */
    public function config_returns_a_config_item()
    {
        $formatter = new TestFormatter(['key1' => 'val1']);
        $this->assertEquals('val1', $formatter->config('key1'));
    }

    /** @test */
    public function config_returns_default_if_config_not_given()
    {
        $formatter = new TestFormatter(['key1' => 'val1']);
        $this->assertEquals('defaultval', $formatter->config('key2', 'defaultval'));
    }
    
    
    
}

class TestFormatter extends Formatter 
{

    /**
     * @var string
     */
    private $handles;

    /**
     * @var \Closure
     */
    private $callback;

    public function handlesShouldReturn(string $handles)
    {
        $this->handles = $handles;
    }

    public function formatItemCallback(\Closure $callback)
    {
        $this->callback = $callback;
    }
    
    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        return ($this->callback)($formattedItem);
    }

    public function handles(): string
    {
        return $this->handles;
    }

    public function config(string $key, $default = null)
    {
        return parent::config($key, $default);
    }
}
