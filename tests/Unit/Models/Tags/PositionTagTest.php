<?php


namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;


use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagTest extends TestCase
{

    /** @test */
    public function it_has_an_id_attribute(){
        $positionTag = factory(PositionTag::class)->create(['id' => 1]);
        $this->assertEquals(1, $positionTag->id());
    }

    /** @test */
    public function it_has_a_name_attribute(){
        $positionTag = factory(PositionTag::class)->create(['name' => 'Tag Name']);
        $this->assertEquals('Tag Name', $positionTag->name());
    }

    /** @test */
    public function it_has_a_description_attribute(){
        $positionTag = factory(PositionTag::class)->create(['description' => 'Tag Description']);
        $this->assertEquals('Tag Description', $positionTag->description());
    }

    /** @test */
    public function it_has_a_reference_attribute(){
        $positionTag = factory(PositionTag::class)->create(['reference' => 'tag_reference']);
        $this->assertEquals('tag_reference', $positionTag->reference());
    }

    /** @test */
    public function it_has_a_category_id_attribute(){
        $positionTag = factory(PositionTag::class)->create(['tag_category_id' => 1]);
        $this->assertEquals(1, $positionTag->categoryId());$tags = factory(PositionTag::class)->create();
    }

    /** @test */
    public function it_sets_a_name_attribute(){
        $positionTag = factory(PositionTag::class)->create(['name' => 'Tag Name']);
        $positionTag->setName('Tag Name2');
        $this->assertEquals('Tag Name2', $positionTag->name());
    }

    /** @test */
    public function it_sets_a_description_attribute(){
        $positionTag = factory(PositionTag::class)->create(['description' => 'Tag Description']);
        $positionTag->setDescription('Tag Description2');
        $this->assertEquals('Tag Description2', $positionTag->description());
    }

    /** @test */
    public function it_sets_a_reference_attribute(){
        $positionTag = factory(PositionTag::class)->create(['reference' => 'tag_reference']);
        $positionTag->setReference('tag_reference2');
        $this->assertEquals('tag_reference2', $positionTag->reference());
    }

    /** @test */
    public function it_sets_a_category_id_attribute(){
        $positionTag = factory(PositionTag::class)->create(['tag_category_id' => 1]);
        $positionTag->setTagCategoryId(2);
        $this->assertEquals(2, $positionTag->categoryId());
    }

    /** @test */
    public function it_applies_the_scope(){
        $tags = factory(PositionTag::class, 5)->create();
        factory(RoleTag::class)->create();

        $resolvedTags = PositionTag::all();
        $this->assertEquals(5, $resolvedTags->count());
        foreach($tags as $tag) {
            $this->assertTrue($tag->is($resolvedTags->shift()));
        }
    }
}
