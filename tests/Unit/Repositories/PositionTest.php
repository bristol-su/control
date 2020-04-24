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

    /** @test */
    public function count_returns_the_number_of_positions(){
        $positions = factory(Position::class, 18)->create();
        $positionRepo = new \BristolSU\ControlDB\Repositories\Position();

        $this->assertEquals(18, $positionRepo->count());
    }

    /** @test */
    public function paginate_returns_the_number_of_positions_specified_for_the_given_page(){
        $positions = factory(Position::class, 40)->create();
        $positionRepo = new \BristolSU\ControlDB\Repositories\Position();

        $paginatedPositions = $positionRepo->paginate(2, 10);
        $this->assertEquals(10, $paginatedPositions->count());
        $this->assertTrue($positions[10]->is($paginatedPositions->shift()));
        $this->assertTrue($positions[11]->is($paginatedPositions->shift()));
        $this->assertTrue($positions[12]->is($paginatedPositions->shift()));
        $this->assertTrue($positions[13]->is($paginatedPositions->shift()));
        $this->assertTrue($positions[14]->is($paginatedPositions->shift()));
        $this->assertTrue($positions[15]->is($paginatedPositions->shift()));
        $this->assertTrue($positions[16]->is($paginatedPositions->shift()));
        $this->assertTrue($positions[17]->is($paginatedPositions->shift()));
        $this->assertTrue($positions[18]->is($paginatedPositions->shift()));
        $this->assertTrue($positions[19]->is($paginatedPositions->shift()));
    }

    /** @test */
    public function update_updates_a_position(){
        $dataPosition1 = factory(DataPosition::class)->create();
        $dataPosition2 = factory(DataPosition::class)->create();
        $position = factory(Position::class)->create(['data_provider_id' => $dataPosition1->id()]);

        $this->assertDatabaseHas('control_positions', [
            'id' => $position->id(), 'data_provider_id' => $dataPosition1->id()
        ]);

        $repository = new \BristolSU\ControlDB\Repositories\Position();
        $repository->update($position->id(), $dataPosition2->id());

        $this->assertDatabaseMissing('control_positions', [
            'id' => $position->id(), 'data_provider_id' => $dataPosition1->id()
        ]);
        $this->assertDatabaseHas('control_positions', [
            'id' => $position->id(), 'data_provider_id' => $dataPosition2->id()
        ]);
    }

    /** @test */
    public function update_returns_the_updated_position(){
        $dataPosition1 = factory(DataPosition::class)->create();
        $dataPosition2 = factory(DataPosition::class)->create();
        $position = factory(Position::class)->create(['data_provider_id' => $dataPosition1->id()]);

        $this->assertEquals($dataPosition1->id(), $position->dataProviderId());

        $repository = new \BristolSU\ControlDB\Repositories\Position();
        $updatedPosition = $repository->update($position->id(), $dataPosition2->id());

        $this->assertEquals($dataPosition2->id(), $updatedPosition->dataProviderId());
    }
    
}
