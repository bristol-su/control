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
    public function getAllWhere_returns_models_matching_all_base_attributes()
    {
        $attributes = ['email' => 'email@email.com', 'name' => 'Toby'];

        $dataGroups = factory(DataGroup::class, 2)->create($attributes);
        $otherGroups = factory(DataGroup::class, 2)->create(['email' => 'email@email.com', 'name' => 'Tobasy']);
        $otherGroups2 = factory(DataGroup::class, 2)->create(['email' => 'email2@email.com', 'name' => 'Toby']);

        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $dbDataGroup = $repository->getAllWhere($attributes);

        $this->assertEquals(2, $dbDataGroup->count());
        $this->assertTrue($dataGroups[0]->is($dbDataGroup[0]));
        $this->assertTrue($dataGroups[1]->is($dbDataGroup[1]));
    }

    /** @test */
    public function getAllWhere_returns_fields_containing()
    {
        $attributes = ['email' => 'email@email.com', 'name' => 'Toby'];

        $dataGroups = factory(DataGroup::class, 2)->create($attributes);
        $otherGroups = factory(DataGroup::class, 2)->create(['email' => 'email@email.com', 'name' => 'Toby2']);
        $otherGroups2 = factory(DataGroup::class, 2)->create(['email' => 'email2@email.com', 'name' => 'Toby']);

        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $dbDataGroup = $repository->getAllWhere($attributes);

        $this->assertEquals(4, $dbDataGroup->count());
        $this->assertTrue($dataGroups[0]->is($dbDataGroup[0]));
        $this->assertTrue($dataGroups[1]->is($dbDataGroup[1]));
        $this->assertTrue($otherGroups[0]->is($dbDataGroup[2]));
        $this->assertTrue($otherGroups[1]->is($dbDataGroup[3]));
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
    
    /** @test */
    public function getWhere_also_searches_additional_attributes(){
        DataGroup::addProperty('student_id');
        $dataGroup1 = factory(DataGroup::class)->create(['email' => 'email@email.com']);
        $dataGroup1->saveAdditionalAttribute('student_id', 'xy123');
        $dataGroup2 = factory(DataGroup::class)->create(['email' => 'email@email.com']);
        $dataGroup2->saveAdditionalAttribute('student_id', 'xy1234');
        
        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $dbDataGroup2 = $repository->getWhere(['email' => 'email@email.com', 'student_id' => 'xy1234']);

        $this->assertTrue($dataGroup2->is($dbDataGroup2));
    }

    /** @test */
    public function getAllWhere_returns_all_model_matching_the_attributes(){
        DataGroup::addProperty('additionalAttr');
        $attributes = ['email' => 'email@email.com', 'additional_attributes' => json_encode(['additionalAttr' => 15])];

        $dataGroups = factory(DataGroup::class, 2)->create($attributes);
        factory(DataGroup::class, 4)->create(['additional_attributes' => json_encode(['additionalAttr' => 5])]);

        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $dbDataGroup = $repository->getAllWhere($attributes);

        $this->assertEquals(2, $dbDataGroup->count());
        $this->assertTrue($dataGroups[0]->is($dbDataGroup[0]));
        $this->assertTrue($dataGroups[1]->is($dbDataGroup[1]));
    }

    /** @test */
    public function update_updates_a_group()
    {
        $dataGroup = factory(DataGroup::class)->create([
            'name' => 'Toby',
            'email' => 'support@example.com',
        ]);
        $this->assertDatabaseHas('control_data_group', [
            'id' => $dataGroup->id(),
            'name' => 'Toby',
            'email' => 'support@example.com',
        ]);
        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $repository->update($dataGroup->id(), 'Toby2',  'support@example2.com');
        $this->assertDatabaseMissing('control_data_group', [
            'id' => $dataGroup->id(),
            'name' => 'Toby',
            'email' => 'support@example.com',
        ]);
        $this->assertDatabaseHas('control_data_group', [
            'id' => $dataGroup->id(),
            'name' => 'Toby2',
            'email' => 'support@example2.com',
        ]);

    }

    /** @test */
    public function update_returns_the_updated_group()
    {
        $dataGroup = factory(DataGroup::class)->create([
            'name' => 'Toby',
            'email' => 'support@example.com',
        ]);
        $this->assertEquals('Toby', $dataGroup->name());
        $this->assertEquals('support@example.com', $dataGroup->email());

        $repository = new \BristolSU\ControlDB\Repositories\DataGroup();
        $updatedGroup = $repository->update($dataGroup->id(), 'Toby2', 'support@example2.com');

        $this->assertEquals('Toby2', $updatedGroup->name());
        $this->assertEquals('support@example2.com', $updatedGroup->email());

    }
}
