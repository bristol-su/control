<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\Tests\ControlDB\TestCase;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DataPositionTest extends TestCase
{

    /** @test */
    public function getById_returns_a_data_position_by_id(){
        $dataPosition = factory(DataPosition::class)->create(['id' => 1]);
        
        $repository = new \BristolSU\ControlDB\Repositories\DataPosition();
        $dbDataPosition = $repository->getById(1);
        
        $this->assertTrue($dataPosition->is($dbDataPosition));
    }
    
    /** @test */
    public function getById_throws_a_ModelNotFoundException_if_the_data_position_is_not_found(){
        $this->expectException(ModelNotFoundException::class);

        $repository = new \BristolSU\ControlDB\Repositories\DataPosition();
        $repository->getById(1);
    }
    
    /** @test */
    public function getWhere_returns_the_first_model_matching_the_attributes(){
        $attributes = ['description' => 'description1'];

        $dataPosition = factory(DataPosition::class)->create($attributes);
        
        $repository = new \BristolSU\ControlDB\Repositories\DataPosition();
        $dbDataPosition = $repository->getWhere($attributes);
        
        $this->assertTrue($dataPosition->is($dbDataPosition));
    }

    /** @test */
    public function getWhere_throws_a_ModelNotFoundException_if_a_data_position_is_not_found(){
        $this->expectException(ModelNotFoundException::class);
        
        $attributes = ['description' => 'description1'];

        $dataPosition = factory(DataPosition::class)->create(['description' => 'description2']);

        $repository = new \BristolSU\ControlDB\Repositories\DataPosition();
        $dbDataPosition = $repository->getWhere($attributes);
    }
    
    /** @test */
    public function create_creates_a_new_data_position(){
        $repository = new \BristolSU\ControlDB\Repositories\DataPosition();
        $dataPosition = $repository->create('GrpName', 'description1');
        
        $this->assertDatabaseHas('control_data_position', [
            'name' => 'GrpName',
            'description' => 'description1',
        ]);
    }
    
    /** @test */
    public function create_can_be_called_with_no_arguments(){
        $repository = new \BristolSU\ControlDB\Repositories\DataPosition();
        $dataPosition = $repository->create();

        $this->assertEquals(1, DB::table('control_data_position')->count());
    }
    
    /** @test */
    public function create_returns_the_created_model(){
        $repository = new \BristolSU\ControlDB\Repositories\DataPosition();
        $dataPosition = $repository->create('GrpName', 'description1');
        
        $this->assertInstanceOf(DataPosition::class, $dataPosition);
        
        $this->assertEquals('GrpName', $dataPosition->name());
        $this->assertEquals('description1', $dataPosition->description());
    }

    /** @test */
    public function getWhere_also_searches_additional_attributes(){
        DataPosition::addProperty('student_id');
        $dataPosition1 = factory(DataPosition::class)->create(['name' => 'Name1']);
        $dataPosition1->saveAdditionalAttribute('student_id', 'xy123');
        $dataPosition2 = factory(DataPosition::class)->create(['name' => 'Name1']);
        $dataPosition2->saveAdditionalAttribute('student_id', 'xy1234');

        $repository = new \BristolSU\ControlDB\Repositories\DataPosition();
        $dbDataPosition2 = $repository->getWhere(['name' => 'Name1', 'student_id' => 'xy1234']);

        $this->assertTrue($dataPosition2->is($dbDataPosition2));
    }

}
