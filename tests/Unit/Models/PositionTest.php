<?php

namespace BristolSU\Tests\ControlDB\Unit\Models;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use Illuminate\Support\Facades\DB;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTest extends TestCase
{
    
    /** @test */
    public function an_id_can_be_retrieved_from_the_model()
    {
        $position = factory(Position::class)->create([
            'id' => 4
        ]);

        $this->assertEquals(4, $position->id());
    }
    
    
    /** @test */
    public function tagRelationship_returns_all_tags_the_position_has(){
        $positionTags = factory(PositionTag::class, 5)->create();
        $position = factory(Position::class)->create();

        DB::table('control_taggables')->insert($positionTags->map(function($positionTag) use ($position) {
            return ['tag_id' => $positionTag->id, 'taggable_id' => $position->id, 'taggable_type' => 'position'];
        })->toArray());

        $tags = $position->tagRelationship;
        $this->assertEquals(5, $tags->count());
        foreach($positionTags as $tag) {
            $this->assertTrue($tag->is($tags->shift()));
        }
    }

    /** @test */
    public function tags_returns_all_tags_the_position_has(){
        $positionTags = factory(PositionTag::class, 5)->create();
        $position = factory(Position::class)->create();

        DB::table('control_taggables')->insert($positionTags->map(function($positionTag) use ($position) {
            return ['tag_id' => $positionTag->id, 'taggable_id' => $position->id, 'taggable_type' => 'position'];
        })->toArray());

        $tags = $position->tags();
        $this->assertEquals(5, $tags->count());
        foreach($positionTags as $tag) {
            $this->assertTrue($tag->is($tags->shift()));
        }
    }

    /** @test */
    public function tagRelationship_can_be_used_to_save_a_tag(){
        $tags = factory(PositionTag::class, 5)->make();
        $position = factory(Position::class)->create();

        $position->tagRelationship()->saveMany($tags);

        foreach($tags as $tag) {
            $this->assertDatabaseHas('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $position->id,
                'taggable_type' => 'position'
            ]);
        }
    }

    /** @test */
    public function roleRelationship_returns_all_roles_the_position_has(){
        $position = factory(Position::class)->create();
        $roles = factory(Role::class, 10)->create(['position_id' => $position->id]);

        $positionRoles = $position->roleRelationship;
        $this->assertEquals(10, $positionRoles->count());
        foreach($roles as $role) {
            $this->assertTrue($role->is($positionRoles->shift()));
        }
    }

    /** @test */
    public function roles_returns_all_roles_the_position_has(){
        $position = factory(Position::class)->create();
        $roles = factory(Role::class, 10)->create(['position_id' => $position->id]);

        $positionRoles = $position->roles();
        $this->assertEquals(10, $positionRoles->count());
        foreach($roles as $role) {
            $this->assertTrue($role->is($positionRoles->shift()));
        }
    }

    /** @test */
    public function roleRelationship_can_be_used_to_save_a_role(){
        $position = factory(Position::class)->create();
        $roles = factory(Role::class, 10)->make();

        $position->roleRelationship()->saveMany($roles);

        $dbRoles = Role::where('position_id', $position->id)->get();
        $this->assertEquals(10, $dbRoles->count());
        foreach($roles as $role) {
            $this->assertTrue($role->is($dbRoles->shift()));
        }
    }

}
