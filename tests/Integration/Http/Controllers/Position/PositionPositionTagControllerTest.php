<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Position;

use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\Tests\ControlDB\TestCase;

class PositionPositionTagControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_tags_through_a_position(){
        $position = Position::factory()->create();
        $positionTags = PositionTag::factory()->count(5)->create();

        foreach($positionTags as $positionTag) {
            $position->addTag($positionTag);
            $this->assertDatabaseHas('control_taggables', [
                'taggable_id' => $position->id(),
                'tag_id' => $positionTag->id(),
                'taggable_type' => 'position'
            ]);
        }

        $response = $this->getJson($this->apiUrl . '/position/' . $position->id() . '/tag');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();

        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $positionTagThroughApi) {
            $this->assertArrayHasKey('id', $positionTagThroughApi);
            $this->assertEquals($positionTags->shift()->id(), $positionTagThroughApi['id']);
        }
    }

    /** @test */
    public function it_tags_a_position(){
        $position = Position::factory()->create();
        $positionTag = PositionTag::factory()->create();

        $this->assertDatabaseMissing('control_taggables', [
            'taggable_id' => $position->id(),
            'tag_id' => $positionTag->id(),
            'taggable_type' => 'position'
        ]);

        $response = $this->patchJson(
            $this->apiUrl . '/position/' . $position->id() . '/tag/' . $positionTag->id()
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $position->id(),
            'tag_id' => $positionTag->id(),
            'taggable_type' => 'position'
        ]);
    }

    /** @test */
    public function it_untags_a_position(){
        $position = Position::factory()->create();
        $positionTag = PositionTag::factory()->create();

        $position->addTag($positionTag);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $position->id(),
            'tag_id' => $positionTag->id(),
            'taggable_type' => 'position'
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/position/' . $position->id() . '/tag/' . $positionTag->id()
        );

        $response->assertStatus(200);

        $this->assertSoftDeleted('control_taggables', [
            'taggable_id' => $position->id(),
            'tag_id' => $positionTag->id(),
            'taggable_type' => 'position'
        ]);


    }

}
