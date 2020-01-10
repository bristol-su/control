<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use BristolSU\Tests\ControlDB\TestCase;

class UserTest extends TestCase
{

    /** @test */
    public function getById_returns_a_user_model_with_the_corresponding_id(){
        $user = factory(User::class)->create(['id' => 2]);
        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $this->assertTrue(
            $user->is($userRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_user_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $userRepo->getById(5);
    }

    /** @test */
    public function create_creates_a_new_user_model(){
        $dataUser = factory(DataUser::class)->create();
        
        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $user = $userRepo->create($dataUser->id);

        $this->assertDatabaseHas('control_users', [
            'data_provider_id' => $dataUser->id
        ]);
    }

    /** @test */
    public function create_returns_the_new_user_model(){
        $dataUser = factory(DataUser::class)->create();
        
        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $user = $userRepo->create($dataUser->id);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($dataUser->id, $user->dataProviderId());
    }

    /** @test */
    public function all_returns_all_users(){
        $users = factory(User::class, 15)->create();
        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $repoUsers = $userRepo->all();
        foreach($users as $user) {
            $this->assertTrue($user->is(
                $repoUsers->shift()
            ));
        }
    }

    /** @test */
    public function getByDataProviderId_returns_a_user_model_with_a_given_data_provider_id()
    {
        $dataUser = factory(DataUser::class)->create();
        $user = factory(User::class)->create(['data_provider_id' => $dataUser->id]);
        
        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $dbUser = $userRepo->getByDataProviderId($dataUser->id);

        $this->assertInstanceOf(User::class, $dbUser);
        $this->assertEquals($dataUser->id, $dbUser->dataProviderId());
        $this->assertEquals($user->id, $dbUser->dataProviderId());
    }

    /** @test */
    public function getByDataProviderId_throws_an_exception_if_no_model_found()
    {
        $this->expectException(ModelNotFoundException::class);
        factory(User::class)->create(['data_provider_id' => 10]);

        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $userRepo->getByDataProviderId(11);

    }

}
