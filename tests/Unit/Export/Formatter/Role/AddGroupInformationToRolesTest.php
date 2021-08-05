<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Formatter\Role;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Role\AddGroupInformationToRoles;
use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class AddGroupInformationToRolesTest extends TestCase
{

    /** @test */
    public function it_adds_group_information_to_a_role_item(){
        $dataGroup1 = DataGroup::factory()->create(['name' => 'Group1', 'email' => 'group1@example.com']);
        $dataGroup2 = DataGroup::factory()->create(['name' => 'Group2', 'email' => 'group2@example.com']);
        $dataGroup3 = DataGroup::factory()->create(['name' => 'Group3', 'email' => 'group3@example.com']);
        $group1 = Group::factory()->create(['data_provider_id' => $dataGroup1->id()]);
        $group2 = Group::factory()->create(['data_provider_id' => $dataGroup2->id()]);
        $group3 = Group::factory()->create(['data_provider_id' => $dataGroup3->id()]);
        
        $formatter = new AddGroupInformationToRoles([]);
        $items = $formatter->format([
            FormattedItem::create(Role::factory()->create(['group_id' => $group1])),
            FormattedItem::create(Role::factory()->create(['group_id' => $group2])),
            FormattedItem::create(Role::factory()->create(['group_id' => $group3])),
        ]);
        
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
