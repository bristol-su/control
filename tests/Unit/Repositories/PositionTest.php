<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

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


}
