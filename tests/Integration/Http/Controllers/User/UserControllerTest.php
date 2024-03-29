<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\User;

use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class UserControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_users()
    {
        $users = User::factory()->count(5)->create();
        $response = $this->getJson($this->apiUrl . '/user');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();

        $response->assertPaginatedJsonCount(5);
        foreach ($response->paginatedJson() as $userThroughApi) {
            $this->assertArrayHasKey('id', $userThroughApi);
            $this->assertEquals($users->shift()->id(), $userThroughApi['id']);
        }
    }

    /** @test */
    public function it_limits_users_by_the_pagination_options(){
        $users = User::factory()->count(50)->create();
        $response = $this->getJson($this->apiUrl . '/user?page=2&per_page=15');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(15);
        $paginatedUsers = $users->slice(15, 15)->values();
        foreach ($response->paginatedJson() as $userThroughApi) {
            $this->assertArrayHasKey('id', $userThroughApi);
            $this->assertEquals($paginatedUsers->shift()->id(), $userThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_user()
    {
        $dataUser = DataUser::factory()->create();
        $user = User::factory()->create(['data_provider_id' => $dataUser->id()]);
        $response = $this->getJson($this->apiUrl . '/user/' . $user->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $user->id()]);
        $response->assertJson(['data_provider_id' => $dataUser->id()]);
    }

    /** @test */
    public function it_updates_a_user()
    {
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00', 'preferred_name' => 'JJ'
        ]);
        $user = User::factory()->create(['data_provider_id' => $dataUser->id()]);

        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00', 'preferred_name' => 'JJ'
        ]);

        $response = $this->patchJson($this->apiUrl . '/user/' . $user->id(), [
            'first_name' => 'Jayne', 'last_name' => 'Smith', 'email' => 'email2@email.com', 'dob' => '14-02-1910', 'preferred_name' => 'Jack'
        ]);

        $response->assertJsonFragment([
            'first_name' => 'Jayne', 'last_name' => 'Smith', 'email' => 'email2@email.com', 'dob' => '1910-02-14 00:00:00', 'preferred_name' => 'Jack'
        ]);

        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'Jayne', 'last_name' => 'Smith', 'email' => 'email2@email.com', 'dob' => '1910-02-14 00:00:00', 'preferred_name' => 'Jack'
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_creates_a_user()
    {

        $response = $this->postJson($this->apiUrl . '/user', [
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '14-02-1908', 'preferred_name' => 'JJ'
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00', 'preferred_name' => 'JJ'
        ]);

        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00', 'preferred_name' => 'JJ'
        ]);

        $dataUser = DataUser::findOrFail($response->json('data.id'));
        $response->assertJsonFragment(['id' => $dataUser->id()]);
    }


    /** @test */
    public function it_deletes_a_user()
    {
        $user = User::factory()->create();

        $this->assertDatabaseHas('control_users', [
            'id' => $user->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/user/' . $user->id());

        $this->assertSoftDeleted('control_users', [
            'id' => $user->id
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_updates_a_user_with_additional_attributes()
    {
        DataUser::addProperty('student_id');
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00',
            'preferred_name' => 'JJ', 'additional_attributes' => json_encode(['student_id' => 'xyz123'])
        ]);
        $user = User::factory()->create(['data_provider_id' => $dataUser->id()]);

        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00',
            'preferred_name' => 'JJ', 'additional_attributes' => json_encode(['student_id' => 'xyz123'])
        ]);

        $response = $this->patchJson($this->apiUrl . '/user/' . $user->id(), [
            'first_name' => 'Jayne', 'last_name' => 'Smith', 'email' => 'email2@email.com', 'dob' => '14-02-1910',
            'preferred_name' => 'Jack', 'student_id' => 'xyz789'
        ]);
        $response->assertStatus(200);

        $response->assertJsonFragment([
            'first_name' => 'Jayne', 'last_name' => 'Smith', 'email' => 'email2@email.com', 'dob' => '1910-02-14 00:00:00', 'preferred_name' => 'Jack', 'student_id' => 'xyz789'
        ]);

        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'Jayne', 'last_name' => 'Smith', 'email' => 'email2@email.com', 'dob' => '1910-02-14 00:00:00', 'preferred_name' => 'Jack', 'additional_attributes' => json_encode(['student_id' => 'xyz789'])
        ]);

    }


    /** @test */
    public function it_creates_a_user_with_additional_attributes()
    {
        DataUser::addProperty('student_id');

        $response = $this->postJson($this->apiUrl . '/user', [
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '14-02-1908', 'preferred_name' => 'JJ', 'student_id' => 'xyz1234'
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00', 'preferred_name' => 'JJ', 'student_id' => 'xyz1234'
        ]);

        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00',
            'preferred_name' => 'JJ', 'additional_attributes' => json_encode(['student_id' => 'xyz1234'])
        ]);

        $dataUser = DataUser::findOrFail($response->json('data.id'));
        $response->assertJsonFragment(['id' => $dataUser->id()]);
    }

}
