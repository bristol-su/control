<?php


namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;


use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\User;
use Illuminate\Support\Facades\DB;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagTest extends TestCase
{
    // TODO Test name method
    // TODO Test description method
    // TODO Test reference method
    // TODO Test categoryId method
    /** @test */
    public function it_has_an_id_attribute(){
        $positionTag = factory(PositionTag::class)->create(['id' => 1]);
        $this->assertEquals(1, $positionTag->id());
    }
    
    /** @test */
    public function category_returns_the_owning_category(){
        $positionTagCategory = factory(PositionTagCategory::class)->create();
        $positionTag = factory(PositionTag::class)->create(['tag_category_id' => $positionTagCategory->id]);

        $this->assertInstanceOf(PositionTagCategory::class, $positionTag->category());
        $this->assertTrue($positionTagCategory->is($positionTag->category()));
    }

    /** @test */
    public function position_relationship_can_be_used_to_tag_a_position(){
        $positionTag = factory(PositionTag::class)->create();

        $taggedPositions = factory(Position::class, 5)->make();
        $positionTag->positionRelationship()->saveMany($taggedPositions);

        $positionPositionRelationship = $positionTag->positionRelationship;
        $this->assertEquals(5, $positionPositionRelationship->count());
        foreach($taggedPositions as $position) {
            $this->assertTrue($position->is($positionPositionRelationship->shift()));
        }
    }

    /** @test */
    public function position_returns_all_positions_tagged(){
        $positionTag = factory(PositionTag::class)->create();
        // Models which could be linked to a tag. Positions, roles and positions should never be returned
        $taggedPositions = factory(Position::class, 5)->create();
        $untaggedPositions = factory(Position::class, 5)->create();
        $groups = factory(Group::class, 5)->create();
        $roles = factory(Role::class, 5)->create();
        $users = factory(User::class, 5)->create();

        DB::table('control_taggables')->insert($taggedPositions->map(function($position) use ($positionTag) {
            return ['tag_id' => $positionTag->id, 'taggable_id' => $position->id, 'taggable_type' => 'position'];
        })->toArray());

        $positionPositionRelationship = $positionTag->positions();
        $this->assertEquals(5, $positionPositionRelationship->count());
        foreach($taggedPositions as $position) {
            $this->assertTrue($position->is($positionPositionRelationship->shift()));
        }
    }

    /** @test */
    public function fullReference_returns_the_category_reference_and_the_tag_reference(){
        $positionTagCategory = factory(PositionTagCategory::class)->create(['reference' => 'categoryreference1']);
        $positionTag = factory(PositionTag::class)->create(['reference' => 'tagreference1', 'tag_category_id' => $positionTagCategory->id]);

        $this->assertEquals('categoryreference1.tagreference1', $positionTag->fullReference());
    }

}
