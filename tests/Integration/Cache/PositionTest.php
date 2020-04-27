<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache;

use BristolSU\ControlDB\Contracts\Repositories\Position as PositionRepository;
use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Position;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Prophecy\Argument;

class PositionTest extends TestCase
{

    /** @test */
    public function getById_saves_the_position_in_the_cache(){
        $position = factory(Position::class)->create();
        
        $positionRepository = $this->prophesize(PositionRepository::class);
        $positionRepository->getById($position->id())->shouldBeCalled()->willReturn($position);
        
        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Position::class . '@getById:' . $position->id();
        
        $positionCache = new \BristolSU\ControlDB\Cache\Position($positionRepository->reveal(), $cache);
        
        $this->assertFalse($cache->has($key));
        $this->assertTrue($position->is($positionCache->getById($position->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($position->is($cache->get($key)));
    }

    /** @test */
    public function getByDataProviderId_saves_the_position_in_the_cache(){
        $dataProvider = factory(DataPosition::class)->create();
        $position = factory(Position::class)->create(['data_provider_id' => $dataProvider->id()]);

        $positionRepository = $this->prophesize(PositionRepository::class);
        $positionRepository->getByDataProviderId($position->id())->shouldBeCalled()->willReturn($position);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Position::class . '@getByDataProviderId:' . $dataProvider->id();

        $positionCache = new \BristolSU\ControlDB\Cache\Position($positionRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($position->is($positionCache->getByDataProviderId($dataProvider->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($position->is($cache->get($key)));
    }

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $positions = factory(Position::class, 5)->create();

        $positionRepository = $this->prophesize(PositionRepository::class);
        $positionRepository->all()->shouldBeCalled()->willReturn($positions);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionCache = new \BristolSU\ControlDB\Cache\Position($positionRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $positionCache->all());
    }

    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $dataProvider = factory(DataPosition::class)->create();
        $position = factory(Position::class)->create(['data_provider_id' => $dataProvider->id()]);

        $positionRepository = $this->prophesize(PositionRepository::class);
        $positionRepository->create($dataProvider->id())->shouldBeCalled()->willReturn($position);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionCache = new \BristolSU\ControlDB\Cache\Position($positionRepository->reveal(), $cache->reveal());

        $this->assertTrue($position->is($positionCache->create($dataProvider->id())));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $position = factory(Position::class)->create();

        $positionRepository = $this->prophesize(PositionRepository::class);
        $positionRepository->delete($position->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionCache = new \BristolSU\ControlDB\Cache\Position($positionRepository->reveal(), $cache->reveal());

        $this->assertNull($positionCache->delete($position->id()));
    }

    /** @test */
    public function paginate_does_not_save_in_the_cache()
    {
        $positions = factory(Position::class, 5)->create();

        $positionRepository = $this->prophesize(PositionRepository::class);
        $positionRepository->paginate(1, 2)->shouldBeCalled()->willReturn($positions);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionCache = new \BristolSU\ControlDB\Cache\Position($positionRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $positionCache->paginate(1,  2));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $dataProvider = factory(DataPosition::class)->create();
        $position = factory(Position::class)->create(['data_provider_id' => $dataProvider->id()]);

        $positionRepository = $this->prophesize(PositionRepository::class);
        $positionRepository->update($position->id(), $dataProvider->id())->shouldBeCalled()->willReturn($position);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $positionCache = new \BristolSU\ControlDB\Cache\Position($positionRepository->reveal(), $cache->reveal());

        $this->assertTrue($position->is($positionCache->update($position->id(), $dataProvider->id())));
    }

    /** @test */
    public function count_saves_the_count_in_the_cache(){
        $positionRepository = $this->prophesize(PositionRepository::class);
        $positionRepository->count()->shouldBeCalled()->willReturn(19);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Position::class . '@count';

        $positionCache = new \BristolSU\ControlDB\Cache\Position($positionRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertEquals(19, $positionCache->count());
        $this->assertTrue($cache->has($key));
        $this->assertEquals(19, $cache->get($key));
    }
    
}