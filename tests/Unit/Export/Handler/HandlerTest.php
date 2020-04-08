<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Handler;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Formatter;
use BristolSU\ControlDB\Export\Handler\Handler;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use PHPUnit\Framework\Assert;

class HandlerTest extends TestCase
{

    /** @test */
    public function it_formats_and_saves_all_the_items_through_the_formatters(){
        $user1 = $this->prophesize(User::class);
        $user2 = $this->prophesize(User::class);
        $user1->id()->shouldBeCalled();
        $user2->id()->shouldBeCalled();
        $items = [
            $user1->reveal(),
            $user2->reveal()
        ];
        
        $handler = new TestHandler([
            'formatters' => [
                TestFormatter::class => ['key' => 'val']
            ]
        ]);
        
        $handler->export($items);
        
        $result = $handler->result;
        $this->assertContainsOnlyInstancesOf(FormattedItem::class, $result);
        $this->assertEquals($user1->reveal(), $result[0]->original());
        $this->assertEquals($user2->reveal(), $result[1]->original());
    }
    
    /** @test */
    public function it_throws_an_exception_if_the_formatter_does_not_exist(){
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Formatter TestFormatter\DoesNotExist does not exist');
        
        $user1 = $this->prophesize(User::class);
        $user2 = $this->prophesize(User::class);
        $items = [
            $user1->reveal(),
            $user2->reveal()
        ];

        $handler = new TestHandler([
            'formatters' => [
                'TestFormatter\DoesNotExist' => ['key' => 'val']
            ]
        ]);

        $handler->export($items);

        $result = $handler->result;
        $this->assertContainsOnlyInstancesOf(FormattedItem::class, $result);
        $this->assertEquals($user1->reveal(), $result[0]->original());
        $this->assertEquals($user2->reveal(), $result[1]->original());
    }
    
    /** @test */
    public function it_can_accept_a_collection(){
        $user1 = $this->prophesize(User::class);
        $user2 = $this->prophesize(User::class);
        $user1->id()->shouldBeCalled();
        $user2->id()->shouldBeCalled();
        $items = collect([
            $user1->reveal(),
            $user2->reveal()
        ]);

        $handler = new TestHandler([
            'formatters' => [
                TestFormatter::class => ['key' => 'val']
            ]
        ]);

        $handler->export($items);

        $result = $handler->result;
        $this->assertContainsOnlyInstancesOf(FormattedItem::class, $result);
        $this->assertEquals($user1->reveal(), $result[0]->original());
        $this->assertEquals($user2->reveal(), $result[1]->original());
    }
    
}

class TestFormatter extends Formatter
{
    
    public function __construct(array $config)
    {
        Assert::assertEquals([
            'key' => 'val'
        ],$config);
        parent::__construct($config);
    }

    public function formatItem(FormattedItem $formattedItem): FormattedItem
    {
        Assert::assertInstanceOf(User::class, $formattedItem->original());
        $formattedItem->original()->id();
        return $formattedItem;
    }

    public function handles(): string
    {
        return static::ALL;
    }
}

class TestHandler extends Handler
{
    public $result;
    
    protected function save(array $items)
    {
        $this->result = $items;
    }
}