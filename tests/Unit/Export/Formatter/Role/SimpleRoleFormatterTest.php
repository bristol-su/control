<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Formatter\Role;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Role\SimpleRoleFormatter;
use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class SimpleRoleFormatterTest extends TestCase
{

    /** @test */
    public function it_appends_the_role_information(){
        $dataRole1 = factory(DataRole::class)->create(['role_name' => 'Role1', 'email' => 'role1@example.com']);
        $dataRole2 = factory(DataRole::class)->create(['role_name' => 'Role2', 'email' => 'role2@example.com']);
        $dataRole3 = factory(DataRole::class)->create(['role_name' => 'Role3', 'email' => 'role3@example.com']);
        $role1 = factory(Role::class)->create(['data_provider_id' => $dataRole1->id()]);
        $role2 = factory(Role::class)->create(['data_provider_id' => $dataRole2->id()]);
        $role3 = factory(Role::class)->create(['data_provider_id' => $dataRole3->id()]);

        $formatter = new SimpleRoleFormatter([]);
        $items = $formatter->format([FormattedItem::create($role1), FormattedItem::create($role2), FormattedItem::create($role3)]);

        $this->assertCount(3, $items);
        $this->assertEquals([
            'Role ID' => $role1->id(), 'Role Name' => 'Role1', 'Role Email' => 'role1@example.com'
        ], $items[0]->preparedItems());
        $this->assertEquals([
            'Role ID' => $role2->id(), 'Role Name' => 'Role2', 'Role Email' => 'role2@example.com'
        ], $items[1]->preparedItems());
        $this->assertEquals([
            'Role ID' => $role3->id(), 'Role Name' => 'Role3', 'Role Email' => 'role3@example.com'
        ], $items[2]->preparedItems());
    }
    
}