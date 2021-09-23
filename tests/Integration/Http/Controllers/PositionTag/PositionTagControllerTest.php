<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\PositionTag;

use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagControllerTest extends TestCase
{

    /** @test */
    public function it_returns_all_position_tags(){
        $positionTags = PositionTag::factory()->count(5)->create();
        $response = $this->getJson($this->apiUrl . '/position-tag');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();

        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $positionTagThroughApi) {
            $this->assertArrayHasKey('id', $positionTagThroughApi);
            $this->assertEquals($positionTags->shift()->id(), $positionTagThroughApi['id']);
        }
    }

    /** @test */
    public function it_returns_a_single_positionTag(){
        $positionTag = PositionTag::factory()->create();
        $response = $this->getJson($this->apiUrl . '/position-tag/' . $positionTag->id());

        $response->assertStatus(200);
        $response->assertJson(['id' => $positionTag->id()]);
    }

    /** @test */
    public function it_updates_a_position_tag(){
        $tagCategory1 = PositionTagCategory::factory()->create();
        $tagCategory2 = PositionTagCategory::factory()->create();

        $positionTag = PositionTag::factory()->create([
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory1->id()
        ]);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory1->id()
        ]);

        $response = $this->patchJson($this->apiUrl . '/position-tag/' . $positionTag->id(), [
            'name' => 'tag2', 'description' => 'ATag2', 'reference' => 'tag2a', 'tag_category_id' => $tagCategory2->id()
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'tag2', 'description' => 'ATag2', 'reference' => 'tag2a', 'tag_category_id' => $tagCategory2->id()
        ]);

    }

    /** @test */
    public function it_creates_a_position_tag(){
        $tagCategory = PositionTagCategory::factory()->create();

        $response = $this->postJson($this->apiUrl . '/position-tag', [
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory->id()
        ]);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory->id()
        ]);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'tag1', 'description' => 'ATag1', 'reference' => 'tag1a', 'tag_category_id' => $tagCategory->id()
        ]);
    }


    /** @test */
    public function it_deletes_a_position_tag(){
        $positionTag = PositionTag::factory()->create();

        $this->assertDatabaseHas('control_tags', [
            'id' => $positionTag->id
        ]);

        $response = $this->deleteJson($this->apiUrl . '/position-tag/' . $positionTag->id());

        $this->assertSoftDeleted('control_tags', [
            'id' => $positionTag->id
        ]);

        $response->assertStatus(200);
    }

}
