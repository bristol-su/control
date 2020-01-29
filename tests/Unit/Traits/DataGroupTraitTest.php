<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Tests\ControlDB\TestCase;

class DataGroupTraitTest extends TestCase
{
    /** @test */
    public function group_returns_the_group(){
        $dataGroup = factory(DataGroup::class)->create();
        $group = factory(Group::class)->create(['data_provider_id' => $dataGroup->id()]);
        
        $this->assertInstanceOf(Group::class, $dataGroup->group());
        $this->assertTrue($group->is($dataGroup->group()));
    }
    
    /** @test */
    public function it_returns_null_if_no_group_found(){
        $dataGroup = factory(DataGroup::class)->create();
        $this->assertNull($dataGroup->group());
    }
}