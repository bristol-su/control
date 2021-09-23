<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Collection;

class UserTest extends TestCase
{

    /** @test */
    public function getById_returns_a_user_model_with_the_corresponding_id(){
        $user = User::factory()->create(['id' => 2]);
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
        $dataUser = DataUser::factory()->create();

        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $user = $userRepo->create($dataUser->id);

        $this->assertDatabaseHas('control_users', [
            'data_provider_id' => $dataUser->id
        ]);
    }

    /** @test */
    public function create_returns_the_new_user_model(){
        $dataUser = DataUser::factory()->create();

        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $user = $userRepo->create($dataUser->id);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($dataUser->id, $user->dataProviderId());
    }

    /** @test */
    public function all_returns_all_users(){
        $users = User::factory()->count(15)->create();
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
        $dataUser = DataUser::factory()->create();
        $user = User::factory()->create(['data_provider_id' => $dataUser->id]);

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
        User::factory()->create(['data_provider_id' => 10]);

        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $userRepo->getByDataProviderId(11);

    }

    /** @test */
    public function delete_deletes_a_user_model(){
        $user = User::factory()->create();
        $userRepo = new \BristolSU\ControlDB\Repositories\User();
        $userRepo->delete($user->id());

        $user->refresh();
        $this->assertTrue($user->trashed());
    }

    /** @test */
    public function count_returns_the_number_of_users(){
        $users = User::factory()->count(18)->create();
        $userRepo = new \BristolSU\ControlDB\Repositories\User();

        $this->assertEquals(18, $userRepo->count());
    }

    /** @test */
    public function paginate_returns_the_number_of_users_specified_for_the_given_page(){
        $users = User::factory()->count(40)->create();
        $userRepo = new \BristolSU\ControlDB\Repositories\User();

        $paginatedUsers = $userRepo->paginate(2, 10);
        $this->assertEquals(10, $paginatedUsers->count());
        $this->assertTrue($users[10]->is($paginatedUsers->shift()));
        $this->assertTrue($users[11]->is($paginatedUsers->shift()));
        $this->assertTrue($users[12]->is($paginatedUsers->shift()));
        $this->assertTrue($users[13]->is($paginatedUsers->shift()));
        $this->assertTrue($users[14]->is($paginatedUsers->shift()));
        $this->assertTrue($users[15]->is($paginatedUsers->shift()));
        $this->assertTrue($users[16]->is($paginatedUsers->shift()));
        $this->assertTrue($users[17]->is($paginatedUsers->shift()));
        $this->assertTrue($users[18]->is($paginatedUsers->shift()));
        $this->assertTrue($users[19]->is($paginatedUsers->shift()));
    }

    /** @test */
    public function update_updates_a_user(){
        $dataUser1 = DataUser::factory()->create();
        $dataUser2 = DataUser::factory()->create();
        $user = User::factory()->create(['data_provider_id' => $dataUser1->id()]);

        $this->assertDatabaseHas('control_users', [
            'id' => $user->id(), 'data_provider_id' => $dataUser1->id()
        ]);

        $repository = new \BristolSU\ControlDB\Repositories\User();
        $repository->update($user->id(), $dataUser2->id());

        $this->assertDatabaseMissing('control_users', [
            'id' => $user->id(), 'data_provider_id' => $dataUser1->id()
        ]);
        $this->assertDatabaseHas('control_users', [
            'id' => $user->id(), 'data_provider_id' => $dataUser2->id()
        ]);
    }

    /** @test */
    public function update_returns_the_updated_user(){
        $dataUser1 = DataUser::factory()->create();
        $dataUser2 = DataUser::factory()->create();
        $user = User::factory()->create(['data_provider_id' => $dataUser1->id()]);

        $this->assertEquals($dataUser1->id(), $user->dataProviderId());

        $repository = new \BristolSU\ControlDB\Repositories\User();
        $updatedUser = $repository->update($user->id(), $dataUser2->id());

        $this->assertEquals($dataUser2->id(), $updatedUser->dataProviderId());
    }
}
