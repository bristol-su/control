<?php


namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;


use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagTest extends TestCase
{

    /** @test */
    public function it_has_an_id_attribute(){
        $positionTag = PositionTag::factory()->create(['id' => 1]);
        $this->assertEquals(1, $positionTag->id());
    }

    /** @test */
    public function it_has_a_name_attribute(){
        $positionTag = PositionTag::factory()->create(['name' => 'Tag Name']);
        $this->assertEquals('Tag Name', $positionTag->name());
    }

    /** @test */
    public function it_has_a_description_attribute(){
        $positionTag = PositionTag::factory()->create(['description' => 'Tag Description']);
        $this->assertEquals('Tag Description', $positionTag->description());
    }

    /** @test */
    public function it_has_a_reference_attribute(){
        $positionTag = PositionTag::factory()->create(['reference' => 'tag_reference']);
        $this->assertEquals('tag_reference', $positionTag->reference());
    }

    /** @test */
    public function it_has_a_category_id_attribute(){
        $positionTag = PositionTag::factory()->create(['tag_category_id' => 1]);
        $this->assertEquals(1, $positionTag->categoryId());$tags = PositionTag::factory()->create();
    }

    /** @test */
    public function it_sets_a_name_attribute(){
        $positionTag = PositionTag::factory()->create(['name' => 'Tag Name']);
        $positionTag->setName('Tag Name2');
        $this->assertEquals('Tag Name2', $positionTag->name());
    }

    /** @test */
    public function it_sets_a_description_attribute(){
        $positionTag = PositionTag::factory()->create(['description' => 'Tag Description']);
        $positionTag->setDescription('Tag Description2');
        $this->assertEquals('Tag Description2', $positionTag->description());
    }

    /** @test */
    public function it_sets_a_reference_attribute(){
        $positionTag = PositionTag::factory()->create(['reference' => 'tag_reference']);
        $positionTag->setReference('tag_reference2');
        $this->assertEquals('tag_reference2', $positionTag->reference());
    }

    /** @test */
    public function it_sets_a_category_id_attribute(){
        $tagCategory1 = PositionTagCategory::factory()->create();
        $tagCategory2 = PositionTagCategory::factory()->create();
        $positionTag = PositionTag::factory()->create(['tag_category_id' => $tagCategory1->id]);
        $positionTag->setTagCategoryId($tagCategory2->id);
        $this->assertEquals($tagCategory2->id, $positionTag->categoryId());
    }

    /** @test */
    public function it_applies_the_scope(){
        $tags = PositionTag::factory()->count(5)->create();
        RoleTag::factory()->create();

        $resolvedTags = PositionTag::all();
        $this->assertEquals(5, $resolvedTags->count());
        foreach($tags as $tag) {
            $this->assertTrue($tag->is($resolvedTags->shift()));
        }
    }

    /** @test */
    public function it_appends_the_full_reference_to_the_tag(){
        $tagCategory = PositionTagCategory::factory()->create(['reference' => 'cat_ref']);
        $tag = PositionTag::factory()->create(['reference' => 'tag_ref', 'tag_category_id' => $tagCategory->id]);

        $array =  $tag->toArray();

        $this->assertArrayHasKey('full_reference', $array);
        $this->assertEquals('cat_ref.tag_ref', $array['full_reference']);
    }
}
