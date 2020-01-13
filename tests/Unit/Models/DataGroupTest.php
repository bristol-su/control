<?php

namespace BristolSU\Tests\ControlDB\Unit\Models;


use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\Tests\ControlDB\TestCase;

class DataGroupTest extends TestCase
{
    
    /** @test */
    public function a_data_group_can_be_created(){
        factory(DataGroup::class)->create([
            'name' => 'Group1',
            'email' => 'email1@email.com',
        ]);
        
        $this->assertDatabaseHas('control_data_group', [
            'name' => 'Group1',
            'email' => 'email1@email.com',
        ]);
        
    }

    /** @test */
    public function an_empty_data_group_can_be_created(){
        $dataGroup = factory(DataGroup::class)->create([
            'name' => null,
            'email' => null,
        ]);

        $this->assertDatabaseHas('control_data_group', [
            'id' => $dataGroup->id,
            'name' => null,
            'email' => null,
        ]);

    }

    /** @test */
    public function an_id_can_be_retrieved_from_the_model()
    {
        $dataGroup = factory(DataGroup::class)->create([
            'id' => 4
        ]);

        $this->assertEquals(4, $dataGroup->id());
    }

    /** @test */
    public function a_name_can_be_retrieved_from_the_model()
    {
        $dataGroup = factory(DataGroup::class)->create([
            'name' => 'Group1'
        ]);

        $this->assertEquals('Group1', $dataGroup->name());
    }

    /** @test */
    public function an_email_can_be_retrieved_from_the_model()
    {
        $dataGroup = factory(DataGroup::class)->create([
            'email' => 'email@email.com'
        ]);

        $this->assertEquals('email@email.com', $dataGroup->email());
    }

    /** @test */
    public function a_name_can_be_set_on_the_model()
    {
        $dataGroup = factory(DataGroup::class)->create([
            'name' => 'Group1'
        ]);

        $dataGroup->setName('Group2');
        
        $this->assertEquals('Group2', $dataGroup->name());
    }

    /** @test */
    public function an_email_can_be_set_on_the_model()
    {
        $dataGroup = factory(DataGroup::class)->create([
            'email' => 'email@email.com'
        ]);
        
        $dataGroup->setEmail('newemail@email.com');

        $this->assertEquals('newemail@email.com', $dataGroup->email());
    }

}
