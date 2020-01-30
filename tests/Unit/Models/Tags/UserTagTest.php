<?php


namespace BristolSU\Tests\ControlDB\Unit\Models\Tags;


use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagTest extends TestCase
{

    /** @test */
    public function it_has_an_id_attribute(){
        $userTag = factory(UserTag::class)->create(['id' => 1]);
        $this->assertEquals(1, $userTag->id());
    }

    /** @test */
    public function it_has_a_name_attribute(){
        $userTag = factory(UserTag::class)->create(['name' => 'Tag Name']);
        $this->assertEquals('Tag Name', $userTag->name());
    }

    /** @test */
    public function it_has_a_description_attribute(){
        $userTag = factory(UserTag::class)->create(['description' => 'Tag Description']);
        $this->assertEquals('Tag Description', $userTag->description());
    }

    /** @test */
    public function it_has_a_reference_attribute(){
        $userTag = factory(UserTag::class)->create(['reference' => 'tag_reference']);
        $this->assertEquals('tag_reference', $userTag->reference());
    }

    /** @test */
    public function it_has_a_category_id_attribute(){
        $userTag = factory(UserTag::class)->create(['tag_category_id' => 1]);
        $this->assertEquals(1, $userTag->categoryId());$tags = factory(UserTag::class)->create();
    }

    /** @test */
    public function it_sets_a_name_attribute(){
        $userTag = factory(UserTag::class)->create(['name' => 'Tag Name']);
        $userTag->setName('Tag Name2');
        $this->assertEquals('Tag Name2', $userTag->name());
    }

    /** @test */
    public function it_sets_a_description_attribute(){
        $userTag = factory(UserTag::class)->create(['description' => 'Tag Description']);
        $userTag->setDescription('Tag Description2');
        $this->assertEquals('Tag Description2', $userTag->description());
    }

    /** @test */
    public function it_sets_a_reference_attribute(){
        $userTag = factory(UserTag::class)->create(['reference' => 'tag_reference']);
        $userTag->setReference('tag_reference2');
        $this->assertEquals('tag_reference2', $userTag->reference());
    }

    /** @test */
    public function it_sets_a_category_id_attribute(){
        $userTag = factory(UserTag::class)->create(['tag_category_id' => 1]);
        $userTag->setTagCategoryId(2);
        $this->assertEquals(2, $userTag->categoryId());
    }

    /** @test */
    public function it_applies_the_scope(){
        $tags = factory(UserTag::class, 5)->create();
        factory(RoleTag::class)->create();

        $resolvedTags = UserTag::all();
        $this->assertEquals(5, $resolvedTags->count());
        foreach($tags as $tag) {
            $this->assertTrue($tag->is($resolvedTags->shift()));
        }
    }
}
