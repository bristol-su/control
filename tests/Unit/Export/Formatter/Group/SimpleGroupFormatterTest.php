<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Formatter\Group;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Group\SimpleGroupFormatter;
use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Tests\ControlDB\TestCase;

class SimpleGroupFormatterTest extends TestCase
{

    /** @test */
    public function it_appends_the_group_information(){
        $dataGroup1 = DataGroup::factory()->create(['name' => 'Group1', 'email' => 'group1@example.com']);
        $dataGroup2 = DataGroup::factory()->create(['name' => 'Group2', 'email' => 'group2@example.com']);
        $dataGroup3 = DataGroup::factory()->create(['name' => 'Group3', 'email' => 'group3@example.com']);
        $group1 = Group::factory()->create(['data_provider_id' => $dataGroup1->id()]);
        $group2 = Group::factory()->create(['data_provider_id' => $dataGroup2->id()]);
        $group3 = Group::factory()->create(['data_provider_id' => $dataGroup3->id()]);
    
        $formatter = new SimpleGroupFormatter([]);
        $items = $formatter->format([FormattedItem::create($group1), FormattedItem::create($group2), FormattedItem::create($group3)]);
        
        $this->assertCount(3, $items);
        $this->assertEquals([
            'Group ID' => $group1->id(), 'Group Name' => 'Group1', 'Group Email' => 'group1@example.com'
        ], $items[0]->preparedItems());
        $this->assertEquals([
            'Group ID' => $group2->id(), 'Group Name' => 'Group2', 'Group Email' => 'group2@example.com'
        ], $items[1]->preparedItems());
        $this->assertEquals([
            'Group ID' => $group3->id(), 'Group Name' => 'Group3', 'Group Email' => 'group3@example.com'
        ], $items[2]->preparedItems());
    }
    
}
