<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Repositories\DataPosition as DataPositionRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Prophecy\Argument;

class DataPositionTest extends TestCase
{

    /** @test */
    public function getById_saves_the_position_in_the_cache(){
        $dataPosition = DataPosition::factory()->create();

        $positionRepository = $this->prophesize(DataPositionRepository::class);
        $positionRepository->getById($dataPosition->id())->shouldBeCalled()->willReturn($dataPosition);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\DataPosition::class . '@getById:' . $dataPosition->id();

        $positionCache = new \BristolSU\ControlDB\Cache\DataPosition($positionRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($dataPosition->is($positionCache->getById($dataPosition->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($dataPosition->is($cache->get($key)));
    }

    /** @test */
    public function getWhere_does_not_save_in_the_cache()
    {
        $position = DataPosition::factory()->create();

        $positionRepository = $this->prophesize(DataPositionRepository::class);
        $positionRepository->getWhere(['email' => 'test@test.com'])->shouldBeCalled()->willReturn($position);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionCache = new \BristolSU\ControlDB\Cache\DataPosition($positionRepository->reveal(), $cache->reveal());

        $this->assertTrue($position->is($positionCache->getWhere(['email' => 'test@test.com'])));
    }

    /** @test */
    public function getAllWhere_does_not_save_in_the_cache()
    {
        $positions = DataPosition::factory()->count(5)->create();

        $positionRepository = $this->prophesize(DataPositionRepository::class);
        $positionRepository->getAllWhere(['email' => 'test@test.com'])->shouldBeCalled()->willReturn($positions);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionCache = new \BristolSU\ControlDB\Cache\DataPosition($positionRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $positionCache->getAllWhere(['email' => 'test@test.com']));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $position = DataPosition::factory()->create();

        $positionRepository = $this->prophesize(DataPositionRepository::class);
        $positionRepository->update($position->id(), 'N', 'E')->shouldBeCalled()->willReturn($position);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionCache = new \BristolSU\ControlDB\Cache\DataPosition($positionRepository->reveal(), $cache->reveal());

        $this->assertTrue($position->is($positionCache->update($position->id(), 'N', 'E')));
    }

    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $position = DataPosition::factory()->create();

        $positionRepository = $this->prophesize(DataPositionRepository::class);
        $positionRepository->create('N', 'E')->shouldBeCalled()->willReturn($position);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionCache = new \BristolSU\ControlDB\Cache\DataPosition($positionRepository->reveal(), $cache->reveal());

        $this->assertTrue($position->is($positionCache->create('N', 'E')));
    }


}
