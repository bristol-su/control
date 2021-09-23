<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Tests\ControlDB\TestCase;

class DataGroupTraitTest extends TestCase
{
    /** @test */
    public function group_returns_the_group(){
        $dataGroup = DataGroup::factory()->create();
        $group = Group::factory()->create(['data_provider_id' => $dataGroup->id()]);
        
        $this->assertInstanceOf(Group::class, $dataGroup->group());
        $this->assertTrue($group->is($dataGroup->group()));
    }
    
    /** @test */
    public function it_returns_null_if_no_group_found(){
        $dataGroup = DataGroup::factory()->create();
        $this->assertNull($dataGroup->group());
    }
    
    /** @test */
    public function setName_updates_the_name()
    {
        $dataGroup = DataGroup::factory()->create(['email' => 'email@example.com']);
        $dataGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class);
        $dataGroupRepo->update($dataGroup->id(), 'NewName', 'email@example.com')->shouldBeCalled()->willReturn($dataGroup);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class, $dataGroupRepo->reveal());
        
        $dataGroup->setName('NewName');
    }

    /** @test */
    public function setEmail_updates_the_email()
    {
        $dataGroup = DataGroup::factory()->create(['name' => 'name1']);
        $dataGroupRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class);
        $dataGroupRepo->update($dataGroup->id(), 'name1', 'email2@example.com')->shouldBeCalled()->willReturn($dataGroup);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataGroup::class, $dataGroupRepo->reveal());

        $dataGroup->setEmail('email2@example.com');
    }
}
