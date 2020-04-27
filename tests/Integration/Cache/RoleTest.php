<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache;

use BristolSU\ControlDB\Contracts\Repositories\Role as RoleRepository;
use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Prophecy\Argument;

class RoleTest extends TestCase
{

    /** @test */
    public function getById_saves_the_role_in_the_cache(){
        $role = factory(Role::class)->create();
        
        $roleRepository = $this->prophesize(RoleRepository::class);
        $roleRepository->getById($role->id())->shouldBeCalled()->willReturn($role);
        
        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Role::class . '@getById:' . $role->id();
        
        $roleCache = new \BristolSU\ControlDB\Cache\Role($roleRepository->reveal(), $cache);
        
        $this->assertFalse($cache->has($key));
        $this->assertTrue($role->is($roleCache->getById($role->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($role->is($cache->get($key)));
    }

    /** @test */
    public function getByDataProviderId_saves_the_role_in_the_cache(){
        $dataProvider = factory(DataRole::class)->create();
        $role = factory(Role::class)->create(['data_provider_id' => $dataProvider->id()]);

        $roleRepository = $this->prophesize(RoleRepository::class);
        $roleRepository->getByDataProviderId($role->id())->shouldBeCalled()->willReturn($role);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Role::class . '@getByDataProviderId:' . $dataProvider->id();

        $roleCache = new \BristolSU\ControlDB\Cache\Role($roleRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($role->is($roleCache->getByDataProviderId($dataProvider->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($role->is($cache->get($key)));
    }

    /** @test */
    public function all_does_not_save_in_the_cache()
    {
        $roles = factory(Role::class, 5)->create();

        $roleRepository = $this->prophesize(RoleRepository::class);
        $roleRepository->all()->shouldBeCalled()->willReturn($roles);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleCache = new \BristolSU\ControlDB\Cache\Role($roleRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $roleCache->all());
    }

    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $dataProvider = factory(DataRole::class)->create();
        $group = factory(Group::class)->create();
        $position = factory(Position::class)->create();
        $role = factory(Role::class)->create(['data_provider_id' => $dataProvider->id(), 'group_id' => $group->id(), 'position_id' => $position->id()]);

        $roleRepository = $this->prophesize(RoleRepository::class);
        $roleRepository->create($position->id(), $group->id(), $dataProvider->id())->shouldBeCalled()->willReturn($role);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleCache = new \BristolSU\ControlDB\Cache\Role($roleRepository->reveal(), $cache->reveal());

        $this->assertTrue($role->is($roleCache->create($position->id(), $group->id(), $dataProvider->id())));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $role = factory(Role::class)->create();

        $roleRepository = $this->prophesize(RoleRepository::class);
        $roleRepository->delete($role->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleCache = new \BristolSU\ControlDB\Cache\Role($roleRepository->reveal(), $cache->reveal());

        $this->assertNull($roleCache->delete($role->id()));
    }

    /** @test */
    public function paginate_does_not_save_in_the_cache()
    {
        $roles = factory(Role::class, 5)->create();

        $roleRepository = $this->prophesize(RoleRepository::class);
        $roleRepository->paginate(1, 2)->shouldBeCalled()->willReturn($roles);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleCache = new \BristolSU\ControlDB\Cache\Role($roleRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $roleCache->paginate(1,  2));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $group = factory(Group::class)->create();
        $position = factory(Position::class)->create();
        $dataProvider = factory(DataRole::class)->create();
        $role = factory(Role::class)->create(['data_provider_id' => $dataProvider->id()]);

        $roleRepository = $this->prophesize(RoleRepository::class);
        $roleRepository->update($role->id(), $position->id(), $group->id(), $dataProvider->id())->shouldBeCalled()->willReturn($role);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $roleCache = new \BristolSU\ControlDB\Cache\Role($roleRepository->reveal(), $cache->reveal());

        $this->assertTrue($role->is($roleCache->update($role->id(), $position->id(), $group->id(), $dataProvider->id())));
    }

    /** @test */
    public function count_saves_the_count_in_the_cache(){
        $roleRepository = $this->prophesize(RoleRepository::class);
        $roleRepository->count()->shouldBeCalled()->willReturn(19);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Role::class . '@count';

        $roleCache = new \BristolSU\ControlDB\Cache\Role($roleRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertEquals(19, $roleCache->count());
        $this->assertTrue($cache->has($key));
        $this->assertEquals(19, $cache->get($key));
    }

    /** @test */
    public function allThroughGroup_saves_all_roles_with_a_group_in_the_cache(){
        $group = factory(Group::class)->create();
        $roles = factory(Role::class, 5)->create(['group_id' => $group->id()]);

        $roleRepository = $this->prophesize(RoleRepository::class);
        $roleRepository->allThroughGroup(Argument::that(function($arg) use ($group) {
            return $arg instanceof Group && $arg->is($group);
        }))->shouldBeCalled()->willReturn($roles);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Role::class . '@allThroughGroup:' . $group->id();

        $roleCache = new \BristolSU\ControlDB\Cache\Role($roleRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $roleCache->allThroughGroup($group));
        $this->assertTrue($cache->has($key));
        $this->assertCount(5, $cache->get($key));
    }

    /** @test */
    public function allThroughPosition_saves_all_roles_with_a_position_in_the_cache(){
        $position = factory(Position::class)->create();
        $roles = factory(Role::class, 5)->create(['position_id' => $position->id()]);

        $roleRepository = $this->prophesize(RoleRepository::class);
        $roleRepository->allThroughPosition(Argument::that(function($arg) use ($position) {
            return $arg instanceof Position && $arg->is($position);
        }))->shouldBeCalled()->willReturn($roles);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\Role::class . '@allThroughPosition:' . $position->id();

        $roleCache = new \BristolSU\ControlDB\Cache\Role($roleRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertCount(5, $roleCache->allThroughPosition($position));
        $this->assertTrue($cache->has($key));
        $this->assertCount(5, $cache->get($key));
    }
    
}