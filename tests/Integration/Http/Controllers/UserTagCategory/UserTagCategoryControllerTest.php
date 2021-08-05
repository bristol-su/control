<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\UserTagCategory;

use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagCategoryControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_user_tag_categories(){
        $userTagCategories = UserTagCategory::factory()->count(5)->create();
        $response = $this->getJson($this->apiUrl . '/user-tag-category');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $userTagCategoryThroughApi) {
            $this->assertArrayHasKey('id', $userTagCategoryThroughApi);
            $this->assertEquals($userTagCategories->shift()->id(), $userTagCategoryThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_userTagCategory(){
        $userTagCategory = UserTagCategory::factory()->create();
        $response = $this->getJson($this->apiUrl . '/user-tag-category/' . $userTagCategory->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $userTagCategory->id()]);
    }

    /** @test */
    public function it_updates_a_user_tag_category(){
        $userTagCategory = UserTagCategory::factory()->create([
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);

        $response = $this->patchJson($this->apiUrl . '/user-tag-category/' . $userTagCategory->id(), [
            'name' => 'tagCategory2', 'description' => 'ATagCategory2', 'reference' => 'tagCategory2a'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'tagCategory2', 'description' => 'ATagCategory2', 'reference' => 'tagCategory2a'
        ]);

    }

    /** @test */
    public function it_creates_a_user_tag_category(){
        $response = $this->postJson($this->apiUrl . '/user-tag-category', [
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
    public function it_deletes_a_user_tag_category(){
        $userTagCategory = UserTagCategory::factory()->create();

        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $userTagCategory->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/user-tag-category/' . $userTagCategory->id());

        $this->assertSoftDeleted('control_tag_categories', [
            'id' => $userTagCategory->id
        ]);

        $response->assertStatus(200);
    }

}
