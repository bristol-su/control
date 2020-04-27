<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\DataRole;
use BristolSU\Tests\ControlDB\TestCase;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DataRoleTest extends TestCase
{

    /** @test */
    public function getById_returns_a_data_role_by_id(){
        $dataRole = factory(DataRole::class)->create(['id' => 1]);
        
        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $dbDataRole = $repository->getById(1);
        
        $this->assertTrue($dataRole->is($dbDataRole));
    }
    
    /** @test */
    public function getById_throws_a_ModelNotFoundException_if_the_data_role_is_not_found(){
        $this->expectException(ModelNotFoundException::class);

        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $repository->getById(1);
    }
    
    /** @test */
    public function getWhere_returns_the_first_model_matching_the_attributes(){
        $attributes = ['email' => 'email@email.com'];

        $dataRole = factory(DataRole::class)->create($attributes);
        
        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $dbDataRole = $repository->getWhere($attributes);
        
        $this->assertTrue($dataRole->is($dbDataRole));
    }

    /** @test */
    public function getWhere_throws_a_ModelNotFoundException_if_a_data_role_is_not_found(){
        $this->expectException(ModelNotFoundException::class);
        
        $attributes = ['email' => 'email@email.com'];

        $dataRole = factory(DataRole::class)->create(['email' => 'email2@email2.com']);

        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $dbDataRole = $repository->getWhere($attributes);
    }
    
    /** @test */
    public function create_creates_a_new_data_role(){
        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $dataRole = $repository->create('GrpRole_name', 'email@email.com');
        
        $this->assertDatabaseHas('control_data_role', [
            'role_name' => 'GrpRole_name',
            'email' => 'email@email.com',
        ]);
    }
    
    /** @test */
    public function create_can_be_called_with_no_arguments(){
        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $dataRole = $repository->create();

        $this->assertEquals(1, DB::table('control_data_role')->count());
    }
    
    /** @test */
    public function create_returns_the_created_model(){
        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $dataRole = $repository->create('GrpRole_name', 'email@email.com');
        
        $this->assertInstanceOf(DataRole::class, $dataRole);
        
        $this->assertEquals('GrpRole_name', $dataRole->roleName());
        $this->assertEquals('email@email.com', $dataRole->email());
    }

    /** @test */
    public function getWhere_also_searches_additional_attributes(){
        DataRole::addProperty('student_id');
        $dataRole1 = factory(DataRole::class)->create(['email' => 'email@email.com']);
        $dataRole1->saveAdditionalAttribute('student_id', 'xy123');
        $dataRole2 = factory(DataRole::class)->create(['email' => 'email@email.com']);
        $dataRole2->saveAdditionalAttribute('student_id', 'xy1234');

        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $dbDataRole2 = $repository->getWhere(['email' => 'email@email.com', 'student_id' => 'xy1234']);

        $this->assertTrue($dataRole2->is($dbDataRole2));
    }

    /** @test */
    public function getAllWhere_returns_all_model_matching_the_attributes(){
        DataRole::addProperty('additionalAttr');
        $attributes = ['email' => 'email@email.com', 'additional_attributes' => json_encode(['additionalAttr' => 15])];

        $dataRoles = factory(DataRole::class, 2)->create($attributes);
        factory(DataRole::class, 4)->create(['additional_attributes' => json_encode(['additionalAttr' => 5])]);

        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $dbDataRole = $repository->getAllWhere($attributes);

        $this->assertEquals(2, $dbDataRole->count());
        $this->assertTrue($dataRoles[0]->is($dbDataRole[0]));
        $this->assertTrue($dataRoles[1]->is($dbDataRole[1]));
    }

    /** @test */
    public function update_updates_a_role()
    {
        $dataRole = factory(DataRole::class)->create([
            'role_name' => 'Toby',
            'email' => 'support@example.com',
        ]);
        $this->assertDatabaseHas('control_data_role', [
            'id' => $dataRole->id(),
            'role_name' => 'Toby',
            'email' => 'support@example.com',
        ]);
        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $repository->update($dataRole->id(), 'Toby2',  'support@example2.com');
        $this->assertDatabaseMissing('control_data_role', [
            'id' => $dataRole->id(),
            'role_name' => 'Toby',
            'email' => 'support@example.com',
        ]);
        $this->assertDatabaseHas('control_data_role', [
            'id' => $dataRole->id(),
            'role_name' => 'Toby2',
            'email' => 'support@example2.com',
        ]);

    }

    /** @test */
    public function update_returns_the_updated_role()
    {
        $dataRole = factory(DataRole::class)->create([
            'role_name' => 'Toby',
            'email' => 'support@example.com',
        ]);
        $this->assertEquals('Toby', $dataRole->roleName());
        $this->assertEquals('support@example.com', $dataRole->email());

        $repository = new \BristolSU\ControlDB\Repositories\DataRole();
        $updatedRole = $repository->update($dataRole->id(), 'Toby2', 'support@example2.com');

        $this->assertEquals('Toby2', $updatedRole->roleName());
        $this->assertEquals('support@example2.com', $updatedRole->email());

    }

}
