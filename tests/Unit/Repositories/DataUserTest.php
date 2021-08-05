<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories;

use BristolSU\ControlDB\Models\DataUser;
use BristolSU\Tests\ControlDB\TestCase;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class DataUserTest extends TestCase
{

    /** @test */
    public function getById_returns_a_data_user_by_id()
    {
        $dataUser = DataUser::factory()->create(['id' => 1]);

        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $dbDataUser = $repository->getById(1);

        $this->assertTrue($dataUser->is($dbDataUser));
    }

    /** @test */
    public function getById_throws_a_ModelNotFoundException_if_the_data_user_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $repository->getById(1);
    }

    /** @test */
    public function getAllWhere_returns_all_model_matching_the_attributes()
    {
        DataUser::addProperty('additionalAttr');
        $attributes = ['email' => 'email@email.com', 'additional_attributes' => json_encode(['additionalAttr' => 15])];

        $dataUsers = DataUser::factory()->count(2)->create($attributes);
        DataUser::factory()->count(4)->create(['additional_attributes' => json_encode(['additionalAttr' => 5])]);

        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $dbDataUser = $repository->getAllWhere($attributes);

        $this->assertEquals(2, $dbDataUser->count());
        $this->assertTrue($dataUsers[0]->is($dbDataUser[0]));
        $this->assertTrue($dataUsers[1]->is($dbDataUser[1]));
    }

    /** @test */
    public function getAllWhere_returns_models_matching_all_base_attributes()
    {
        $attributes = ['email' => 'email@email.com', 'first_name' => 'Toby'];

        $dataUsers = DataUser::factory()->count(2)->create($attributes);
        $otherUsers = DataUser::factory()->count(2)->create(['email' => 'email@email.com', 'first_name' => 'Tobasy']);
        $otherUsers2 = DataUser::factory()->count(2)->create(['email' => 'email2@email.com', 'first_name' => 'Tobasy']);

        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $dbDataUser = $repository->getAllWhere($attributes);

        $this->assertEquals(2, $dbDataUser->count());
        $this->assertTrue($dataUsers[0]->is($dbDataUser[0]));
        $this->assertTrue($dataUsers[1]->is($dbDataUser[1]));
    }

    /** @test */
    public function getAllWhere_matches_fields_containing(){
        $attributes = ['email' => 'email@email.com', 'first_name' => 'Toby'];

        $dataUsers = DataUser::factory()->count(2)->create($attributes);
        $otherUsers = DataUser::factory()->count(2)->create(['email' => 'email@email.com', 'first_name' => 'Toby2']);
        $otherUsers2 = DataUser::factory()->count(2)->create(['email' => 'email2@email.com', 'first_name' => 'Tobasy']);

        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $dbDataUser = $repository->getAllWhere($attributes);

        $this->assertEquals(4, $dbDataUser->count());
        $this->assertTrue($dataUsers[0]->is($dbDataUser[0]));
        $this->assertTrue($dataUsers[1]->is($dbDataUser[1]));
        $this->assertTrue($otherUsers[0]->is($dbDataUser[2]));
        $this->assertTrue($otherUsers[1]->is($dbDataUser[3]));
    }

    /** @test */
    public function getWhere_returns_the_first_model_matching_the_attributes()
    {
        $attributes = ['email' => 'email@email.com'];

        $dataUser = DataUser::factory()->create($attributes);

        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $dbDataUser = $repository->getWhere($attributes);

        $this->assertTrue($dataUser->is($dbDataUser));
    }

    /** @test */
    public function getWhere_throws_a_ModelNotFoundException_if_a_data_user_is_not_found()
    {
        $this->expectException(ModelNotFoundException::class);

        $attributes = ['email' => 'email@email.com'];

        $dataUser = DataUser::factory()->create();

        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $dbDataUser = $repository->getWhere($attributes);
    }

    /** @test */
    public function create_creates_a_new_data_user()
    {
        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $dataUser = $repository->create('FirstName', 'Lastname', 'email@email.com', Carbon::make('14-02-1990'), 'TobyT');

        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'FirstName',
            'last_name' => 'Lastname',
            'email' => 'email@email.com',
            'dob' => '1990-02-14 00:00:00',
            'preferred_name' => 'TobyT'
        ]);
    }

    /** @test */
    public function create_can_be_called_with_no_arguments()
    {
        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $dataUser = $repository->create();

        $this->assertEquals(1, DB::table('control_data_user')->count());
    }

    /** @test */
    public function create_returns_the_created_model()
    {
        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $dataUser = $repository->create('FirstName', 'Lastname', 'email@email.com', Carbon::make('14-02-1990'), 'TobyT');

        $this->assertInstanceOf(DataUser::class, $dataUser);

        $this->assertEquals('FirstName', $dataUser->firstName());
        $this->assertEquals('Lastname', $dataUser->lastName());
        $this->assertEquals('email@email.com', $dataUser->email());
        $this->assertEquals(Carbon::make('14-02-1990'), $dataUser->dob());
        $this->assertEquals('TobyT', $dataUser->preferredName());
    }

    /** @test */
    public function getWhere_also_searches_additional_attributes()
    {
        DataUser::addProperty('student_id');
        $dataUser1 = DataUser::factory()->create(['email' => 'email@email.com']);
        $dataUser1->saveAdditionalAttribute('student_id', 'xy123');
        $dataUser2 = DataUser::factory()->create(['email' => 'email@email.com']);
        $dataUser2->saveAdditionalAttribute('student_id', 'xy1234');

        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $dbDataUser2 = $repository->getWhere(['email' => 'email@email.com', 'student_id' => 'xy1234']);

        $this->assertTrue($dataUser2->is($dbDataUser2));
    }

    /** @test */
    public function update_updates_a_user()
    {
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'support@example.com',
            'dob' => Carbon::create(1850, 12, 20),
            'preferred_name' => 'Toby T'
        ]);
        $this->assertDatabaseHas('control_data_user', [
            'id' => $dataUser->id(),
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'support@example.com',
            'dob' => '1850-12-20 00:00:00',
            'preferred_name' => 'Toby T'
        ]);
        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $repository->update($dataUser->id(), 'Toby2', 'Twigger2', 'support@example2.com',
            Carbon::create(1950, 8, 15), 'Toby T2');
        $this->assertDatabaseMissing('control_data_user', [
            'id' => $dataUser->id(),
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'support@example.com',
            'dob' => '1850-12-20 00:00:00',
            'preferred_name' => 'Toby T'
        ]);
        $this->assertDatabaseHas('control_data_user', [
            'id' => $dataUser->id(),
            'first_name' => 'Toby2',
            'last_name' => 'Twigger2',
            'email' => 'support@example2.com',
            'dob' => '1950-08-15 00:00:00',
            'preferred_name' => 'Toby T2'
        ]);

    }

    /** @test */
    public function update_returns_the_updated_user()
    {
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'support@example.com',
            'dob' => Carbon::create(1850, 12, 20),
            'preferred_name' => 'Toby T'
        ]);
        $this->assertEquals('Toby', $dataUser->firstName());
        $this->assertEquals('Twigger', $dataUser->lastName());
        $this->assertEquals('support@example.com', $dataUser->email());
        $this->assertTrue(Carbon::create(1850, 12, 20)->equalTo($dataUser->dob()));
        $this->assertEquals('Toby T', $dataUser->preferredName());

        $repository = new \BristolSU\ControlDB\Repositories\DataUser();
        $updatedUser = $repository->update($dataUser->id(), 'Toby2', 'Twigger2', 'support@example2.com',
            Carbon::create(1950, 8, 15), 'Toby T2');

        $this->assertEquals('Toby2', $updatedUser->firstName());
        $this->assertEquals('Twigger2', $updatedUser->lastName());
        $this->assertEquals('support@example2.com', $updatedUser->email());
        $this->assertTrue(Carbon::create(1950, 8, 15)->equalTo($updatedUser->dob()));
        $this->assertEquals('Toby T2', $updatedUser->preferredName());

    }

}
