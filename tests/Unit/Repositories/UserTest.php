<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

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
        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $user = $userRepo->create('forename1', 'surname1', 'email@email.com');

        $this->assertDatabaseHas('control_users', [
            'forename' => 'forename1',
            'surname' => 'surname1',
            'email' => 'email@email.com'
        ]);
    }

    /** @test */
    public function create_returns_the_new_user_model(){
        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $user = $userRepo->create('forename1', 'surname1', 'email@email.com');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('forename1', $user->forename());
        $this->assertEquals('surname', $user->surname());
        $this->assertEquals('email@email.com', $user->email());
    }

    /** @test */
    public function it_throws_an_exception_if_the_user_email_already_exists(){
        $this->expectException(ModelNotFoundException::class);

        $user = factory(User::class)->create(['email' => 'email1@email.com']);
        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $userRepo->create('forename1', 'surname1', 'email1@email.com');
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

}
