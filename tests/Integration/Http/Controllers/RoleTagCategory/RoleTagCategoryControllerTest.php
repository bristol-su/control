<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\RoleTagCategory;

use BristolSU\ControlDB\Models\Tags\RoleTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagCategoryControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_role_tag_categories(){
        $roleTagCategories = factory(RoleTagCategory::class, 5)->create();
        $response = $this->getJson($this->apiUrl . '/role-tag-category');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
        foreach($response->json() as $roleTagCategoryThroughApi) {
            $this->assertArrayHasKey('id', $roleTagCategoryThroughApi);
            $this->assertEquals($roleTagCategories->shift()->id(), $roleTagCategoryThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_roleTagCategory(){
        $roleTagCategory = factory(RoleTagCategory::class)->create();
        $response = $this->getJson($this->apiUrl . '/role-tag-category/' . $roleTagCategory->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $roleTagCategory->id()]);
    }

    /** @test */
    public function it_updates_a_role_tag_category(){
        $roleTagCategory = factory(RoleTagCategory::class)->create([
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);

        $response = $this->patchJson($this->apiUrl . '/role-tag-category/' . $roleTagCategory->id(), [
            'name' => 'tagCategory2', 'description' => 'ATagCategory2', 'reference' => 'tagCategory2a'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'tagCategory2', 'description' => 'ATagCategory2', 'reference' => 'tagCategory2a'
        ]);

    }

    /** @test */
    public function it_creates_a_role_tag_category(){
        $response = $this->postJson($this->apiUrl . '/role-tag-category', [
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
    public function it_deletes_a_role_tag_category(){
        $roleTagCategory = factory(RoleTagCategory::class)->create();

        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $roleTagCategory->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/role-tag-category/' . $roleTagCategory->id());

        $this->assertSoftDeleted('control_tag_categories', [
            'id' => $roleTagCategory->id
        ]);

        $response->assertStatus(200);
    }

}