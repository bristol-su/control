<?php

namespace BristolSU\Tests\ControlDB\Integration\Cache;

use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Repositories\DataUser as DataUserRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Contracts\Cache\Repository;
use Prophecy\Argument;

class DataUserTest extends TestCase
{

    /** @test */
    public function getById_saves_the_user_in_the_cache(){
        $dataUser = DataUser::factory()->create();

        $userRepository = $this->prophesize(DataUserRepository::class);
        $userRepository->getById($dataUser->id())->shouldBeCalled()->willReturn($dataUser);

        $cache = app(Repository::class);
        $key = \BristolSU\ControlDB\Cache\DataUser::class . '@getById:' . $dataUser->id();

        $userCache = new \BristolSU\ControlDB\Cache\DataUser($userRepository->reveal(), $cache);

        $this->assertFalse($cache->has($key));
        $this->assertTrue($dataUser->is($userCache->getById($dataUser->id())));
        $this->assertTrue($cache->has($key));
        $this->assertTrue($dataUser->is($cache->get($key)));
    }

    /** @test */
    public function getWhere_does_not_save_in_the_cache()
    {
        $user = DataUser::factory()->create();

        $userRepository = $this->prophesize(DataUserRepository::class);
        $userRepository->getWhere(['email' => 'test@test.com'])->shouldBeCalled()->willReturn($user);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userCache = new \BristolSU\ControlDB\Cache\DataUser($userRepository->reveal(), $cache->reveal());

        $this->assertTrue($user->is($userCache->getWhere(['email' => 'test@test.com'])));
    }

    /** @test */
    public function getAllWhere_does_not_save_in_the_cache()
    {
        $users = DataUser::factory()->count(5)->create();

        $userRepository = $this->prophesize(DataUserRepository::class);
        $userRepository->getAllWhere(['email' => 'test@test.com'])->shouldBeCalled()->willReturn($users);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userCache = new \BristolSU\ControlDB\Cache\DataUser($userRepository->reveal(), $cache->reveal());

        $this->assertCount(5, $userCache->getAllWhere(['email' => 'test@test.com']));
    }

    /** @test */
    public function update_does_not_save_in_the_cache()
    {
        $user = DataUser::factory()->create();

        $userRepository = $this->prophesize(DataUserRepository::class);
        $userRepository->update($user->id(), 'F', 'L', 'E', null, 'PN')->shouldBeCalled()->willReturn($user);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userCache = new \BristolSU\ControlDB\Cache\DataUser($userRepository->reveal(), $cache->reveal());

        $this->assertTrue($user->is($userCache->update($user->id(), 'F', 'L', 'E', null, 'PN')));
    }

    /** @test */
    public function create_does_not_save_in_the_cache()
    {
        $user = DataUser::factory()->create();

        $userRepository = $this->prophesize(DataUserRepository::class);
        $userRepository->create('F', 'L', 'E', null, 'PN')->shouldBeCalled()->willReturn($user);

        $cache = $this->prophesize(Repository::class);
        $cache->rememberForever(Argument::any(), Argument::any())->shouldNotBeCalled();

        $userCache = new \BristolSU\ControlDB\Cache\DataUser($userRepository->reveal(), $cache->reveal());

        $this->assertTrue($user->is($userCache->create('F', 'L', 'E', null, 'PN')));
    }


}
