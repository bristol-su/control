<?php

namespace BristolSU\Tests\ControlDB\Unit\Models;


use BristolSU\ControlDB\Models\DataRole;
use BristolSU\Tests\ControlDB\TestCase;

class DataRoleTest extends TestCase
{
    
    /** @test */
    public function a_data_role_can_be_created(){
        factory(DataRole::class)->create([
            'role_name' => 'Role1',
            'email' => 'email1@email.com',
        ]);
        
        $this->assertDatabaseHas('control_data_role', [
            'role_name' => 'Role1',
            'email' => 'email1@email.com',
        ]);
        
    }

    /** @test */
    public function an_empty_data_role_can_be_created(){
        $dataRole = factory(DataRole::class)->create([
            'role_name' => null,
            'email' => null,
        ]);

        $this->assertDatabaseHas('control_data_role', [
            'id' => $dataRole->id,
            'role_name' => null,
            'email' => null,
        ]);

    }

    /** @test */
    public function an_id_can_be_retrieved_from_the_model()
    {
        $dataRole = factory(DataRole::class)->create([
            'id' => 4
        ]);

        $this->assertEquals(4, $dataRole->id());
    }

    /** @test */
    public function a_role_name_can_be_retrieved_from_the_model()
    {
        $dataRole = factory(DataRole::class)->create([
            'role_name' => 'Role1'
        ]);

        $this->assertEquals('Role1', $dataRole->roleName());
    }

    /** @test */
    public function an_email_can_be_retrieved_from_the_model()
    {
        $dataRole = factory(DataRole::class)->create([
            'email' => 'email@email.com'
        ]);

        $this->assertEquals('email@email.com', $dataRole->email());
    }

    /** @test */
    public function a_role_name_can_be_set_on_the_model()
    {
        $dataRole = factory(DataRole::class)->create([
            'role_name' => 'Role1'
        ]);

        $dataRole->setroleName('Role2');
        
        $this->assertEquals('Role2', $dataRole->roleName());
    }

    /** @test */
    public function an_email_can_be_set_on_the_model()
    {
        $dataRole = factory(DataRole::class)->create([
            'email' => 'email@email.com'
        ]);
        
        $dataRole->setEmail('newemail@email.com');

        $this->assertEquals('newemail@email.com', $dataRole->email());
    }

}
