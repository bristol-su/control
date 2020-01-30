<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Position;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTest extends TestCase
{

    /** @test */
    public function getById_returns_a_position_model_with_the_corresponding_id(){
        $position = factory(Position::class)->create(['id' => 2]);
        $positionRepo = new \BristolSU\ControlDB\Repositories\Position();
        $this->assertTrue(
            $position->is($positionRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_position_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $positionRepo = new \BristolSU\ControlDB\Repositories\Position();
        $positionRepo->getById(5);
    }

    /** @test */
    public function create_creates_a_new_position_model(){
        $dataPosition = factory(DataPosition::class)->create();

        $positionRepo = new \BristolSU\ControlDB\Repositories\Position();
        $position = $positionRepo->create($dataPosition->id);

        $this->assertDatabaseHas('control_positions', [
            'data_provider_id' => $dataPosition->id
        ]);
    }

    /** @test */
    public function create_returns_the_new_position_model(){
        $dataPosition = factory(DataPosition::class)->create();

        $positionRepo = new \BristolSU\ControlDB\Repositories\Position();
        $position = $positionRepo->create($dataPosition->id);

        $this->assertInstanceOf(Position::class, $position);
        $this->assertEquals($dataPosition->id, $position->dataProviderId());
    }

    /** @test */
    public function all_returns_all_positions(){
        $positions = factory(Position::class, 15)->create();
        $positionRepo = new \BristolSU\ControlDB\Repositories\Position();
        $repoPositions = $positionRepo->all();
        foreach($positions as $position) {
            $this->assertTrue($position->is(
                $repoPositions->shift()
            ));
        }
    }

    /** @test */
    public function getByDataProviderId_returns_a_position_model_with_a_given_data_provider_id()
    {
        $dataPosition = factory(DataPosition::class)->create();
        $position = factory(Position::class)->create(['data_provider_id' => $dataPosition->id]);

        $positionRepo = new \BristolSU\ControlDB\Repositories\Position();
        $dbPosition = $positionRepo->getByDataProviderId($dataPosition->id);

        $this->assertInstanceOf(Position::class, $dbPosition);
        $this->assertEquals($dataPosition->id, $dbPosition->dataProviderId());
        $this->assertEquals($position->id, $dbPosition->dataProviderId());
    }

    /** @test */
    public function getByDataProviderId_throws_an_exception_if_no_model_found()
    {
        $this->expectException(ModelNotFoundException::class);
        factory(Position::class)->create(['data_provider_id' => 10]);

        $positionRepo = new \BristolSU\ControlDB\Repositories\Position();
        $positionRepo->getByDataProviderId(11);

    }

    /** @test */
    public function delete_deletes_a_position_model(){
        $position = factory(Position::class)->create();
        $positionRepo = new \BristolSU\ControlDB\Repositories\Position();
        $positionRepo->delete($position->id());

        $position->refresh();
        $this->assertTrue($position->trashed());
    }

}
