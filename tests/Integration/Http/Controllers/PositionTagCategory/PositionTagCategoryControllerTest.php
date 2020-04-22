<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\PositionTagCategory;

use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagCategoryControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_position_tag_categories(){
        $positionTagCategories = factory(PositionTagCategory::class, 5)->create();
        $response = $this->getJson($this->apiUrl . '/position-tag-category');
        $response->assertStatus(200);

        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $positionTagCategoryThroughApi) {
            $this->assertArrayHasKey('id', $positionTagCategoryThroughApi);
            $this->assertEquals($positionTagCategories->shift()->id(), $positionTagCategoryThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_positionTagCategory(){
        $positionTagCategory = factory(PositionTagCategory::class)->create();
        $response = $this->getJson($this->apiUrl . '/position-tag-category/' . $positionTagCategory->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $positionTagCategory->id()]);
    }

    /** @test */
    public function it_updates_a_position_tag_category(){
        $positionTagCategory = factory(PositionTagCategory::class)->create([
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'tagCategory1', 'description' => 'ATagCategory1', 'reference' => 'tagCategory1a'
        ]);

        $response = $this->patchJson($this->apiUrl . '/position-tag-category/' . $positionTagCategory->id(), [
            'name' => 'tagCategory2', 'description' => 'ATagCategory2', 'reference' => 'tagCategory2a'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'tagCategory2', 'description' => 'ATagCategory2', 'reference' => 'tagCategory2a'
        ]);

    }

    /** @test */
    public function it_creates_a_position_tag_category(){
        $response = $this->postJson($this->apiUrl . '/position-tag-category', [
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
    public function it_deletes_a_position_tag_category(){
        $positionTagCategory = factory(PositionTagCategory::class)->create();

        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $positionTagCategory->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/position-tag-category/' . $positionTagCategory->id());

        $this->assertSoftDeleted('control_tag_categories', [
            'id' => $positionTagCategory->id
        ]);

        $response->assertStatus(200);
    }

}