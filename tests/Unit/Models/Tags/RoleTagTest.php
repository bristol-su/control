<?php


namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;


use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagTest extends TestCase
{

    /** @test */
    public function it_has_an_id_attribute(){
        $roleTag = factory(RoleTag::class)->create(['id' => 1]);
        $this->assertEquals(1, $roleTag->id());
    }

    /** @test */
    public function it_has_a_name_attribute(){
        $roleTag = factory(RoleTag::class)->create(['name' => 'Tag Name']);
        $this->assertEquals('Tag Name', $roleTag->name());
    }

    /** @test */
    public function it_has_a_description_attribute(){
        $roleTag = factory(RoleTag::class)->create(['description' => 'Tag Description']);
        $this->assertEquals('Tag Description', $roleTag->description());
    }

    /** @test */
    public function it_has_a_reference_attribute(){
        $roleTag = factory(RoleTag::class)->create(['reference' => 'tag_reference']);
        $this->assertEquals('tag_reference', $roleTag->reference());
    }

    /** @test */
    public function it_has_a_category_id_attribute(){
        $roleTag = factory(RoleTag::class)->create(['tag_category_id' => 1]);
        $this->assertEquals(1, $roleTag->categoryId());$tags = factory(RoleTag::class)->create();
    }

    /** @test */
    public function it_sets_a_name_attribute(){
        $roleTag = factory(RoleTag::class)->create(['name' => 'Tag Name']);
        $roleTag->setName('Tag Name2');
        $this->assertEquals('Tag Name2', $roleTag->name());
    }

    /** @test */
    public function it_sets_a_description_attribute(){
        $roleTag = factory(RoleTag::class)->create(['description' => 'Tag Description']);
        $roleTag->setDescription('Tag Description2');
        $this->assertEquals('Tag Description2', $roleTag->description());
    }

    /** @test */
    public function it_sets_a_reference_attribute(){
        $roleTag = factory(RoleTag::class)->create(['reference' => 'tag_reference']);
        $roleTag->setReference('tag_reference2');
        $this->assertEquals('tag_reference2', $roleTag->reference());
    }

    /** @test */
    public function it_sets_a_category_id_attribute(){
        $roleTag = factory(RoleTag::class)->create(['tag_category_id' => 1]);
        $roleTag->setTagCategoryId(2);
        $this->assertEquals(2, $roleTag->categoryId());
    }

    /** @test */
    public function it_applies_the_scope(){
        $tags = factory(RoleTag::class, 5)->create();
        factory(UserTag::class)->create();

        $resolvedTags = RoleTag::all();

        $this->assertEquals(5, $resolvedTags->count());
        foreach($tags as $tag) {
            $this->assertTrue($tag->is($resolvedTags->shift()));
        }
    }
}
