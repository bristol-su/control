<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\User;

use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Carbon\Carbon;

class UserControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_users(){
        $users = factory(User::class, 5)->create();
        $response = $this->getJson($this->apiUrl . '/user');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
        foreach($response->json() as $userThroughApi) {
            $this->assertArrayHasKey('id', $userThroughApi);
            $this->assertEquals($users->shift()->id(), $userThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_user(){
        $dataUser = factory(DataUser::class)->create();
        $user = factory(User::class)->create(['data_provider_id' => $dataUser->id()]);
        $response = $this->getJson($this->apiUrl . '/user/' . $user->id());
        
        $response->assertStatus(200);
        $response->assertJson(['id' => $user->id()]);
        $response->assertJson(['data_provider_id' => $dataUser->id()]);
    }

    /** @test */
    public function it_updates_a_user(){
        $dataUser = factory(DataUser::class)->create([
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00', 'preferred_name' => 'JJ'
        ]);
        $user = factory(User::class)->create(['data_provider_id' => $dataUser->id()]);
        
        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00', 'preferred_name' => 'JJ'
        ]);
        
        $response = $this->patchJson($this->apiUrl . '/user/' . $user->id(), [
            'first_name' => 'Jayne', 'last_name' => 'Smith', 'email' => 'email2@email.com', 'dob' => '14-02-1910', 'preferred_name' => 'Jack'
        ]);

        $response->assertJsonFragment([
            'first_name' => 'Jayne', 'last_name' => 'Smith', 'email' => 'email2@email.com', 'dob' => '14-02-1910', 'preferred_name' => 'Jack'
        ]);
        
        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'Jayne', 'last_name' => 'Smith', 'email' => 'email2@email.com', 'dob' => '1910-02-14 00:00:00', 'preferred_name' => 'Jack'
        ]);
        
        $response->assertStatus(200);
    }

    /** @test */
    public function it_creates_a_user(){

        $response = $this->postJson($this->apiUrl . '/user', [
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '14-02-1908', 'preferred_name' => 'JJ'
        ]);
        
        $response->assertStatus(201);

        $response->assertJsonFragment([
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '14-02-1908', 'preferred_name' => 'JJ'
        ]);
        
        $this->assertDatabaseHas('control_data_user', [
            'first_name' => 'Jane', 'last_name' => 'Jones', 'email' => 'email@email.com', 'dob' => '1908-02-14 00:00:00', 'preferred_name' => 'JJ'
        ]);

        $dataUser = DataUser::findOrFail($response->json('data.id'));
        $response->assertJsonFragment(['id' => $dataUser->id()]);
    }


    /** @test */
    public function it_deletes_a_user(){
        $user = factory(User::class)->create();

        $this->assertDatabaseHas('control_users', [
            'id' => $user->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/user/' . $user->id());

        $this->assertSoftDeleted('control_users', [
            'id' => $user->id
        ]);

        $response->assertStatus(200);
    }
    
}