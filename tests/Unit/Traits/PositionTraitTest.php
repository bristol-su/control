<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\DataPosition;
use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Illuminate\Support\Facades\DB;

class PositionTraitTest extends TestCase
{
    /** @test */
    public function data_returns_the_data_attribute_for_the_position(){
        $dataPosition = factory(DataPosition::class)->create();
        $position = factory(Position::class)->create(['data_provider_id' => $dataPosition->id()]);

        $this->assertInstanceOf(DataPosition::class, $position->data());
        $this->assertTrue($dataPosition->is($position->data()));
    }

    /** @test */
    public function tags_can_be_removed_from_a_position() {
        $tags = factory(PositionTag::class, 5)->create();
        $position = factory(Position::class)->create();

        foreach($tags as $tag) {
            $position->addTag($tag);
        }

        foreach($tags as $tag) {
            $this->assertDatabaseHas('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $position->id,
                'taggable_type' => 'position'
            ]);
            $this->assertDatabaseHas('control_tags', $tag->toArray());
        }

        foreach($tags as $tag) {
            $position->removeTag($tag);
        }

        foreach($tags as $tag) {
            $this->assertSoftDeleted('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $position->id,
                'taggable_type' => 'position'
            ]);
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
    public function tags_can_be_added_to_a_position(){
        $tags = factory(PositionTag::class, 5)->create();
        $position = factory(Position::class)->create();

        foreach($tags as $tag) {
            $position->addTag($tag);
        }

        foreach($tags as $tag) {
            $this->assertDatabaseHas('control_taggables', [
                'tag_id' => $tag->id,
                'taggable_id' => $position->id,
                'taggable_type' => 'position'
            ]);
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

}