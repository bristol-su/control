<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\GroupTagCategory;

use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagCategoryControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_group_tag_categories(){
        $groupTagCategories = GroupTagCategory::factory()->count(5)->create();
        $response = $this->getJson($this->apiUrl . '/group-tag-category');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $groupTagCategoryThroughApi) {
            $this->assertArrayHasKey('id', $groupTagCategoryThroughApi);
            $this->assertEquals($groupTagCategories->shift()->id(), $groupTagCategoryThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_groupTagCategory(){
        $groupTagCategory = GroupTagCategory::factory()->create();
        $response = $this->getJson($this->apiUrl . '/group-tag-category/' . $groupTagCategory->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $groupTagCategory->id()]);
    }

    /** @test */
    public function it_updates_a_group_tag_category(){
        $groupTagCategory = GroupTagCategory::factory()->create([
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);

        $response = $this->patchJson($this->apiUrl . '/group-tag-category/' . $groupTagCategory->id(), [
            'name' => 'tagCategory2', 'description' => 'ATagCategory2', 'reference' => 'tagCategory2a'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'tagCategory2', 'description' => 'ATagCategory2', 'reference' => 'tagCategory2a'
        ]);

    }

    /** @test */
    public function it_creates_a_group_tag_category(){
        $response = $this->postJson($this->apiUrl . '/group-tag-category', [
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);
    }


    /** @test */
    public function it_deletes_a_group_tag_category(){
        $groupTagCategory = GroupTagCategory::factory()->create();

        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $groupTagCategory->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/group-tag-category/' . $groupTagCategory->id());

        $this->assertSoftDeleted('control_tag_categories', [
            'id' => $groupTagCategory->id
        ]);

        $response->assertStatus(200);
    }

}
