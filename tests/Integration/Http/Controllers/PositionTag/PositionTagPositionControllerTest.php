<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\PositionTag;

use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Position;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagPositionControllerTest extends TestCase
{
    /** @test */
    public function it_gets_all_positions_through_a_tag()
    {
        $positionTag = factory(PositionTag::class)->create();
        $positions = factory(Position::class, 5)->create();

        foreach ($positions as $position) {
            $positionTag->addPosition($position);
            $this->assertDatabaseHas('control_taggables', [
                'taggable_id' => $position->id(),
                'tag_id' => $positionTag->id(),
                'taggable_type' => 'position'
            ]);
        }

        $response = $this->getJson($this->apiUrl . '/position-tag/' . $positionTag->id() . '/position');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
        foreach ($response->json() as $positionThroughApi) {
            $this->assertArrayHasKey('id', $positionThroughApi);
            $this->assertEquals($positions->shift()->id(), $positionThroughApi['id']);
        }
    }

    /** @test */
    public function it_tags_a_position()
    {
        $position = factory(Position::class)->create();
        $positionTag = factory(PositionTag::class)->create();

        $this->assertDatabaseMissing('control_taggables', [
            'taggable_id' => $position->id(),
            'tag_id' => $positionTag->id(),
            'taggable_type' => 'position'
        ]);

        $response = $this->patchJson(
            $this->apiUrl . '/position-tag/' . $positionTag->id() . '/position/' . $position->id()
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $position->id(),
            'tag_id' => $positionTag->id(),
            'taggable_type' => 'position'
        ]);
    }

    /** @test */
    public function it_untags_a_position()
    {
        $position = factory(Position::class)->create();
        $positionTag = factory(PositionTag::class)->create();

        $position->addTag($positionTag);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $position->id(),
            'tag_id' => $positionTag->id(),
            'taggable_type' => 'position'
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/position-tag/' . $positionTag->id() . '/position/' . $position->id()
        );

        $response->assertStatus(200);

        $this->assertSoftDeleted('control_taggables', [
            'taggable_id' => $position->id(),
            'tag_id' => $positionTag->id(),
            'taggable_type' => 'position'
        ]);


    }
}