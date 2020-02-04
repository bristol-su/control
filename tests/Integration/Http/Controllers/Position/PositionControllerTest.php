<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Position;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Position;
use BristolSU\Tests\ControlDB\TestCase;

class PositionControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_positions(){
        $positions = factory(Position::class, 5)->create();
        $response = $this->getJson($this->apiUrl . '/position');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
        foreach($response->json() as $positionThroughApi) {
            $this->assertArrayHasKey('id', $positionThroughApi);
            $this->assertEquals($positions->shift()->id(), $positionThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_position(){
        $dataPosition = factory(DataPosition::class)->create();
        $position = factory(Position::class)->create(['data_provider_id' => $dataPosition->id()]);
        $response = $this->getJson($this->apiUrl . '/position/' . $position->id());
        
        $response->assertStatus(200);
        $response->assertJson(['id' => $position->id()]);
        $response->assertJson(['data_provider_id' => $dataPosition->id()]);
    }

    /** @test */
    public function it_updates_a_position(){
        $dataPosition = factory(DataPosition::class)->create(['name' => 'Name1', 'description' => 'description1']);
        $position = factory(Position::class)->create(['data_provider_id' => $dataPosition->id()]);
        
        $this->assertDatabaseHas('control_data_position', [
            'name' => 'Name1', 'description' => 'description1'
        ]);
        
        $response = $this->patchJson($this->apiUrl . '/position/' . $position->id(), [
            'name' => 'Name2', 'description' => 'description2'
        ]);

        $this->assertDatabaseHas('control_data_position', [
            'name' => 'Name2', 'description' => 'description2'
        ]);
        
        $response->assertStatus(200);
    }

    /** @test */
    public function it_creates_a_position(){

        $response = $this->postJson($this->apiUrl . '/position', [
            'name' => 'Name2', 'description' => 'description2'
        ]);
        
        $response->assertStatus(201);

        $response->assertJsonFragment([
            'name' => 'Name2', 'description' => 'description2'
        ]);
        
        $this->assertDatabaseHas('control_data_position', [
            'name' => 'Name2', 'description' => 'description2'
        ]);

        $dataPosition = DataPosition::findOrFail($response->json('data.id'));
        $response->assertJsonFragment(['id' => $dataPosition->id()]);
    }


    /** @test */
    public function it_deletes_a_position(){
        $position = factory(Position::class)->create();

        $this->assertDatabaseHas('control_positions', [
            'id' => $position->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/position/' . $position->id());

        $this->assertSoftDeleted('control_positions', [
            'id' => $position->id
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_creates_a_position_with_additional_attributes()
    {

        DataPosition::addProperty('account_code');

        $response = $this->postJson($this->apiUrl . '/position', [
            'name' => 'Name2', 'description' => 'Description2', 'account_code' => 'CHA'
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'name' => 'Name2', 'description' => 'Description2', 'account_code' => 'CHA'
        ]);

        $this->assertDatabaseHas('control_data_position', [
            'name' => 'Name2', 'description' => 'Description2', 'additional_attributes' => json_encode(['account_code' => 'CHA'])
        ]);

        $dataPosition = DataPosition::findOrFail($response->json('data.id'));
        $response->assertJsonFragment(['id' => $dataPosition->id()]);
    }

    /** @test */
    public function it_updates_a_position_with_additional_attributes()
    {
        DataPosition::addProperty('student_id');
        $dataPosition = factory(DataPosition::class)->create(['name' => 'Name1', 'description' => 'Description', 'additional_attributes' => json_encode(['student_id' => 'xyz123'])]);
        $position = factory(Position::class)->create(['data_provider_id' => $dataPosition->id()]);

        $this->assertDatabaseHas('control_data_position', [
            'name' => 'Name1', 'description' => 'Description', 'additional_attributes' => json_encode(['student_id' => 'xyz123'])
        ]);

        $response = $this->patchJson($this->apiUrl . '/position/' . $position->id(), [
            'name' => 'Name2', 'description' => 'Description2', 'student_id' => 'xzy789'
        ]);

        $response->assertJsonFragment([
            'name' => 'Name2', 'description' => 'Description2', 'student_id' => 'xzy789'
        ]);

        $this->assertDatabaseHas('control_data_position', [
            'name' => 'Name2', 'description' => 'Description2', 'additional_attributes' => json_encode(['student_id' => 'xzy789'])
        ]);

        $response->assertStatus(200);
    }
}