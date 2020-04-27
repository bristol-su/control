<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache;

use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Prophecy\Argument;

class UserTest extends TestCase
{

    /** @test */
    public function getById_saves_the_user_in_the_cache(){
        $user = factory(User::class)->create();
        
        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository->getById($user->id())->shouldBeCalled()->willReturn($user);
        
        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\User::class . '@getById:' . $user->id();
        
        $userCache = new \BristolSU\ControlDB\Cache\User($userRepository->reveal(), $cache);
        
        $this->assertFalse($cache->has($key));
        $this->assertTrue($user->is($userCache->getById($user->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($user->is($cache->get($key)));
    }

    /** @test */
    public function getByDataProviderId_saves_the_user_in_the_cache(){
        $dataProvider = factory(DataUser::class)->create();
        $user = factory(User::class)->create(['data_provider_id' => $dataProvider->id()]);

        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository->getByDataProviderId($user->id())->shouldBeCalled()->willReturn($user);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\User::class . '@getByDataProviderId:' . $dataProvider->id();

        $userCache = new \BristolSU\ControlDB\Cache\User($userRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($user->is($userCache->getByDataProviderId($dataProvider->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($user->is($cache->get($key)));
    }
    

    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $dataProvider = factory(DataUser::class)->create();
        $user = factory(User::class)->create(['data_provider_id' => $dataProvider->id()]);

        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository->create($dataProvider->id())->shouldBeCalled()->willReturn($user);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userCache = new \BristolSU\ControlDB\Cache\User($userRepository->reveal(), $cache->reveal());

        $this->assertTrue($user->is($userCache->create($dataProvider->id())));
    }

    /** @test */
    public function delete_does_not_save_in_the_cache()
    {
        $user = factory(User::class)->create();

        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository->delete($user->id())->shouldBeCalled();

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userCache = new \BristolSU\ControlDB\Cache\User($userRepository->reveal(), $cache->reveal());

        $this->assertNull($userCache->delete($user->id()));
    }

    /** @test */
    public function paginate_does_not_save_in_the_cache()
    {
        $users = factory(User::class, 5)->create();

        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository->paginate(1, 2)->shouldBeCalled()->willReturn($users);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userCache = new \BristolSU\ControlDB\Cache\User($userRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $userCache->paginate(1,  2));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $dataProvider = factory(DataUser::class)->create();
        $user = factory(User::class)->create(['data_provider_id' => $dataProvider->id()]);

        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository->update($user->id(), $dataProvider->id())->shouldBeCalled()->willReturn($user);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userCache = new \BristolSU\ControlDB\Cache\User($userRepository->reveal(), $cache->reveal());

        $this->assertTrue($user->is($userCache->update($user->id(), $dataProvider->id())));
    }

    /** @test */
    public function count_saves_the_count_in_the_cache(){
        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository->count()->shouldBeCalled()->willReturn(19);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\User::class . '@count';

        $userCache = new \BristolSU\ControlDB\Cache\User($userRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertEquals(19, $userCache->count());
        $this->assertTrue($cache->has($key));
        $this->assertEquals(19, $cache->get($key));
    }
    
}