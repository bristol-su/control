<?php

namespace BristolSU\Tests\ControlDB\Unit\Export\Formatter\Role;

use BristolSU\ControlDB\Export\FormattedItem;
use BristolSU\ControlDB\Export\Formatter\Role\AddPositionInformationToRoles;
use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class AddPostionInformationToRolesTest extends TestCase
{

    /** @test */
    public function it_adds_position_information_to_a_role_item(){
        $dataPosition1 = factory(DataPosition::class)->create(['name' => 'Position1']);
        $dataPosition2 = factory(DataPosition::class)->create(['name' => 'Position2']);
        $dataPosition3 = factory(DataPosition::class)->create(['name' => 'Position3']);
        $position1 = factory(Position::class)->create(['data_provider_id' => $dataPosition1->id()]);
        $position2 = factory(Position::class)->create(['data_provider_id' => $dataPosition2->id()]);
        $position3 = factory(Position::class)->create(['data_provider_id' => $dataPosition3->id()]);

        $formatter = new AddPositionInformationToRoles([]);
        $items = $formatter->format([
            FormattedItem::create(factory(Role::class)->create(['position_id' => $position1])),
            FormattedItem::create(factory(Role::class)->create(['position_id' => $position2])),
            FormattedItem::create(factory(Role::class)->create(['position_id' => $position3])),
        ]);

        $this->assertCount(3, $items);
        $this->assertEquals([
            'Position ID' => $position1->id(), 'Position Name' => 'Position1'
        ], $items[0]->preparedItems());
        $this->assertEquals([
            'Position ID' => $position2->id(), 'Position Name' => 'Position2'
        ], $items[1]->preparedItems());
        $this->assertEquals([
            'Position ID' => $position3->id(), 'Position Name' => 'Position3'
        ], $items[2]->preparedItems());
    }
    
}