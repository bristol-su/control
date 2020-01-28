<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Models\Pivots\Tags\GroupGroupTag;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Pivots\Tags\PositionPositionTag;
use BristolSU\ControlDB\Repositories\Pivots\Tags\PositionPositionTag as PositionPositionTagRepository;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Collection;

class PositionPositionTagTest extends TestCase
{
    
    /** @test */
    public function it_gets_all_tags_through_a_position(){
        $position = factory(Position::class)->create();
        $positionTagsForPosition = factory(PositionTag::class, 10)->create();
        $positionTagsNotForPosition = factory(PositionTag::class, 10)->create();
        
        foreach($positionTagsForPosition as $positionTag) {
            PositionPositionTag::create(['tag_id' => $positionTag->id(), 'taggable_id' => $position->id()]);
        }
        
        $positionPositionTag = new PositionPositionTagRepository();
        $retrievedPositionTags = $positionPositionTag->getTagsThroughPosition($position);
        
        $this->assertEquals(10, $retrievedPositionTags->count());
        $this->assertContainsOnlyInstancesOf(PositionTag::class, $retrievedPositionTags);
        foreach($positionTagsForPosition as $positionTag) {
            $this->assertTrue($positionTag->is($retrievedPositionTags->shift()));
        }
    }
    
    /** @test */
    public function it_gets_all_positions_tagged_with_a_tag(){
        $positionTag = factory(PositionTag::class)->create();
        $positionsForPositionTag = factory(Position::class, 10)->create();
        $positionsNotForPositionTag = factory(Position::class, 10)->create();

        foreach($positionsForPositionTag as $position) {
            PositionPositionTag::create(['tag_id' => $positionTag->id(), 'taggable_id' => $position->id()]);
        }

        $positionPositionTag = new PositionPositionTagRepository();
        $retrievedPositions = $positionPositionTag->getPositionsThroughTag($positionTag);

        $this->assertEquals(10, $retrievedPositions->count());
        $this->assertContainsOnlyInstancesOf(Position::class, $retrievedPositions);
        foreach($positionsForPositionTag as $position) {
            $this->assertTrue($position->is($retrievedPositions->shift()));
        }
    }
    
    

    /** @test */
    public function addTagToPosition_adds_a_tag_to_a_position()
    {
        $position = factory(Position::class)->create();
        $positionTag = factory(PositionTag::class)->create();

        $positionPositionTag = new \BristolSU\ControlDB\Repositories\Pivots\Tags\PositionPositionTag();
        $this->assertEquals(0, $positionPositionTag->getTagsThroughPosition($position)->count());

        $positionPositionTag->addTagToPosition($positionTag, $position);

        $this->assertEquals(1, $positionPositionTag->getTagsThroughPosition($position)->count());
        $this->assertInstanceOf(PositionTag::class, $positionPositionTag->getTagsThroughPosition($position)->first());
        $this->assertTrue($positionTag->is($positionPositionTag->getTagsThroughPosition($position)->first()));
    }

    /** @test */
    public function removeTagFromPosition_removes_a_tag_from_a_position()
    {
        $position = factory(Position::class)->create();
        $positionTag = factory(PositionTag::class)->create();
        $positionPositionTag = new \BristolSU\ControlDB\Repositories\Pivots\Tags\PositionPositionTag();

        PositionPositionTag::create([
            'taggable_id' => $position->id(), 'tag_id' => $positionTag->id()
        ]);
        $this->assertEquals(1, $positionPositionTag->getTagsThroughPosition($position)->count());
        $this->assertInstanceOf(PositionTag::class, $positionPositionTag->getTagsThroughPosition($position)->first());
        $this->assertTrue($positionTag->is($positionPositionTag->getTagsThroughPosition($position)->first()));

        $positionPositionTag->removeTagFromPosition($positionTag, $position);
    
        $this->assertEquals(0, $positionPositionTag->getTagsThroughPosition($position)->count());
    }
}