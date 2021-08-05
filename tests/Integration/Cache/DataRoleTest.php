<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache;

use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Repositories\DataRole as DataRoleRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Prophecy\Argument;

class DataRoleTest extends TestCase
{

    /** @test */
    public function getById_saves_the_role_in_the_cache(){
        $dataRole = DataRole::factory()->create();

        $roleRepository = $this->prophesize(DataRoleRepository::class);
        $roleRepository->getById($dataRole->id())->shouldBeCalled()->willReturn($dataRole);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\DataRole::class . '@getById:' . $dataRole->id();

        $roleCache = new \BristolSU\ControlDB\Cache\DataRole($roleRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($dataRole->is($roleCache->getById($dataRole->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($dataRole->is($cache->get($key)));
    }

    /** @test */
    public function getWhere_does_not_save_in_the_cache()
    {
        $role = DataRole::factory()->create();

        $roleRepository = $this->prophesize(DataRoleRepository::class);
        $roleRepository->getWhere(['email' => 'test@test.com'])->shouldBeCalled()->willReturn($role);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleCache = new \BristolSU\ControlDB\Cache\DataRole($roleRepository->reveal(), $cache->reveal());

        $this->assertTrue($role->is($roleCache->getWhere(['email' => 'test@test.com'])));
    }

    /** @test */
    public function getAllWhere_does_not_save_in_the_cache()
    {
        $roles = DataRole::factory()->count(5)->create();

        $roleRepository = $this->prophesize(DataRoleRepository::class);
        $roleRepository->getAllWhere(['email' => 'test@test.com'])->shouldBeCalled()->willReturn($roles);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleCache = new \BristolSU\ControlDB\Cache\DataRole($roleRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $roleCache->getAllWhere(['email' => 'test@test.com']));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $role = DataRole::factory()->create();

        $roleRepository = $this->prophesize(DataRoleRepository::class);
        $roleRepository->update($role->id(), 'N', 'E')->shouldBeCalled()->willReturn($role);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleCache = new \BristolSU\ControlDB\Cache\DataRole($roleRepository->reveal(), $cache->reveal());

        $this->assertTrue($role->is($roleCache->update($role->id(), 'N', 'E')));
    }

    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $role = DataRole::factory()->create();

        $roleRepository = $this->prophesize(DataRoleRepository::class);
        $roleRepository->create('N', 'E')->shouldBeCalled()->willReturn($role);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleCache = new \BristolSU\ControlDB\Cache\DataRole($roleRepository->reveal(), $cache->reveal());

        $this->assertTrue($role->is($roleCache->create('N', 'E')));
    }


}
