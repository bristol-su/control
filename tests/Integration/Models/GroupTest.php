<?php

namespace BristolSU\Tests\ControlDB\Integration\Models;

use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTest extends TestCase
{

    /** @test */
    public function the_data_function_returns_the_data_model(){
        $dataGroup = factory(DataGroup::class)->create();
        $group = factory(Group::class)->create(['data_provider_id' => $dataGroup->id()]);
        
        $this->assertInstanceOf(DataGroup::class, $group->data());
        $this->assertTrue($dataGroup->is(
            $group->data()
        ));
    }

}