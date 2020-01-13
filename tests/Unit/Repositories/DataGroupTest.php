<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\Tests\ControlDB\TestCase;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DataGroupTest extends TestCase
{

    /** @test */
    public function getById_returns_a_data_group_by_id(){
        $dataGroup = factory(DataGroup::class)->create(['id' => 1]);
        
        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $dbDataGroup = $repository->getById(1);
        
        $this->assertTrue($dataGroup->is($dbDataGroup));
    }
    
    /** @test */
    public function getById_throws_a_ModelNotFoundException_if_the_data_group_is_not_found(){
        $this->expectException(ModelNotFoundException::class);

        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $repository->getById(1);
    }
    
    /** @test */
    public function getWhere_returns_the_first_model_matching_the_attributes(){
        $attributes = ['email' => 'email@email.com'];

        $dataGroup = factory(DataGroup::class)->create($attributes);
        
        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $dbDataGroup = $repository->getWhere($attributes);
        
        $this->assertTrue($dataGroup->is($dbDataGroup));
    }

    /** @test */
    public function getWhere_throws_a_ModelNotFoundException_if_a_data_group_is_not_found(){
        $this->expectException(ModelNotFoundException::class);
        
        $attributes = ['email' => 'email@email.com'];

        $dataGroup = factory(DataGroup::class)->create(['email' => 'email2@email2.com']);

        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $dbDataGroup = $repository->getWhere($attributes);
    }
    
    /** @test */
    public function create_creates_a_new_data_group(){
        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $dataGroup = $repository->create('GrpName', 'email@email.com');
        
        $this->assertDatabaseHas('control_data_group', [
            'name' => 'GrpName',
            'email' => 'email@email.com',
        ]);
    }
    
    /** @test */
    public function create_can_be_called_with_no_arguments(){
        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $dataGroup = $repository->create();

        $this->assertEquals(1, DB::table('control_data_group')->count());
    }
    
    /** @test */
    public function create_returns_the_created_model(){
        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $dataGroup = $repository->create('GrpName', 'email@email.com');
        
        $this->assertInstanceOf(DataGroup::class, $dataGroup);
        
        $this->assertEquals('GrpName', $dataGroup->name());
        $this->assertEquals('email@email.com', $dataGroup->email());
    }
    
    

}
