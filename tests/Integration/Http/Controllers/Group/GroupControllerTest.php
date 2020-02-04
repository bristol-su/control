<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Group;

use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\Tests\ControlDB\TestCase;

class GroupControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_groups()
    {
        $groups = factory(Group::class, 5)->create();
        $response = $this->getJson($this->apiUrl . '/group');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
        foreach ($response->json() as $groupThroughApi) {
            $this->assertArrayHasKey('id', $groupThroughApi);
            $this->assertEquals($groups->shift()->id(), $groupThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_group()
    {
        $dataGroup = factory(DataGroup::class)->create();
        $group = factory(Group::class)->create(['data_provider_id' => $dataGroup->id()]);
        $response = $this->getJson($this->apiUrl . '/group/' . $group->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $group->id()]);
        $response->assertJson(['data_provider_id' => $dataGroup->id()]);
    }

    /** @test */
    public function it_updates_a_group()
    {
        $dataGroup = factory(DataGroup::class)->create(['name' => 'Name1', 'email' => 'email@email.com']);
        $group = factory(Group::class)->create(['data_provider_id' => $dataGroup->id()]);

        $this->assertDatabaseHas('control_data_group', [
            'name' => 'Name1', 'email' => 'email@email.com'
        ]);

        $response = $this->patchJson($this->apiUrl . '/group/' . $group->id(), [
            'name' => 'Name2', 'email' => 'email2@email.com'
        ]);

        $this->assertDatabaseHas('control_data_group', [
            'name' => 'Name2', 'email' => 'email2@email.com'
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_updates_a_group_with_additional_attributes()
    {
        DataGroup::addProperty('student_id');
        $dataGroup = factory(DataGroup::class)->create(['name' => 'Name1', 'email' => 'email@email.com', 'additional_attributes' => json_encode(['student_id' => 'xyz123'])]);
        $group = factory(Group::class)->create(['data_provider_id' => $dataGroup->id()]);

        $this->assertDatabaseHas('control_data_group', [
            'name' => 'Name1', 'email' => 'email@email.com', 'additional_attributes' => json_encode(['student_id' => 'xyz123'])
        ]);

        $response = $this->patchJson($this->apiUrl . '/group/' . $group->id(), [
            'name' => 'Name2', 'email' => 'email2@email.com', 'student_id' => 'xzy789'
        ]);
        
        $response->assertJsonFragment([
            'name' => 'Name2', 'email' => 'email2@email.com', 'student_id' => 'xzy789'
        ]);
        
        $this->assertDatabaseHas('control_data_group', [
            'name' => 'Name2', 'email' => 'email2@email.com', 'additional_attributes' => json_encode(['student_id' => 'xzy789'])
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_creates_a_group()
    {

        $response = $this->postJson($this->apiUrl . '/group', [
            'name' => 'Name2', 'email' => 'email2@email.com'
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'name' => 'Name2', 'email' => 'email2@email.com'
        ]);

        $this->assertDatabaseHas('control_data_group', [
            'name' => 'Name2', 'email' => 'email2@email.com'
        ]);

        $dataGroup = DataGroup::findOrFail($response->json('data.id'));
        $response->assertJsonFragment(['id' => $dataGroup->id()]);
    }

    /** @test */
    public function it_creates_a_group_with_additional_attributes()
    {

        DataGroup::addProperty('account_code');

        $response = $this->postJson($this->apiUrl . '/group', [
            'name' => 'Name2', 'email' => 'email2@email.com', 'account_code' => 'CHA'
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'name' => 'Name2', 'email' => 'email2@email.com', 'account_code' => 'CHA'
        ]);

        $this->assertDatabaseHas('control_data_group', [
            'name' => 'Name2', 'email' => 'email2@email.com', 'additional_attributes' => json_encode(['account_code' => 'CHA'])
        ]);

        $dataGroup = DataGroup::findOrFail($response->json('data.id'));
        $response->assertJsonFragment(['id' => $dataGroup->id()]);
    }


    /** @test */
    public function it_deletes_a_group()
    {
        $group = factory(Group::class)->create();

        $this->assertDatabaseHas('control_groups', [
            'id' => $group->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/group/' . $group->id());

        $this->assertSoftDeleted('control_groups', [
            'id' => $group->id
        ]);

        $response->assertStatus(200);
    }

}