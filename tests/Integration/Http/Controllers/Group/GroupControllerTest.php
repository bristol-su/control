<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Group;

use BristolSU\ControlDB\Models\DataGroup;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\Tests\ControlDB\TestCase;

class GroupControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_groups()
    {
        $groups = Group::factory()->count(5)->create();
        $response = $this->getJson($this->apiUrl . '/group');
        $response->assertStatus(200);

        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(5);
        foreach ($response->paginatedJson() as $groupThroughApi) {
            $this->assertArrayHasKey('id', $groupThroughApi);
            $this->assertEquals($groups->shift()->id(), $groupThroughApi['id']);
        }
    }

    /** @test */
    public function it_limits_groups_by_the_pagination_options(){
        $groups = Group::factory()->count(50)->create();
        $response = $this->getJson($this->apiUrl . '/group?page=2&per_page=15');
        $response->assertStatus(200);

        $response->assertPaginatedJsonCount(15);
        $paginatedGroups = $groups->slice(15, 15)->values();
        foreach ($response->paginatedJson() as $groupThroughApi) {
            $this->assertArrayHasKey('id', $groupThroughApi);
            $this->assertEquals($paginatedGroups->shift()->id(), $groupThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_group()
    {
        $dataGroup = DataGroup::factory()->create();
        $group = Group::factory()->create(['data_provider_id' => $dataGroup->id()]);
        $response = $this->getJson($this->apiUrl . '/group/' . $group->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $group->id()]);
        $response->assertJson(['data_provider_id' => $dataGroup->id()]);
    }

    /** @test */
    public function it_updates_a_group()
    {
        $dataGroup = DataGroup::factory()->create(['name' => 'Name1', 'email' => 'email@email.com']);
        $group = Group::factory()->create(['data_provider_id' => $dataGroup->id()]);

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
        $dataGroup = DataGroup::factory()->create(['name' => 'Name1', 'email' => 'email@email.com', 'additional_attributes' => json_encode(['student_id' => 'xyz123'])]);
        $group = Group::factory()->create(['data_provider_id' => $dataGroup->id()]);

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
        $group = Group::factory()->create();

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
