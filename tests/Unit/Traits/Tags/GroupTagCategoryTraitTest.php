<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits\Tags;

use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagCategoryTraitTest extends TestCase
{
    /** @test */
    public function tags_returns_the_linked_tags(){
        $tagCategory1 = factory(GroupTagCategory::class)->create();
        $tags1 = factory(GroupTag::class, 5)->create(['tag_category_id' => $tagCategory1->id]);
        // Data that shouldn't be returned
        $tagCategory2 = factory(GroupTagCategory::class)->create();
        $tags2 = factory(GroupTag::class, 5)->create(['tag_category_id' => $tagCategory2->id]);

        $tagsFromRelationship = $tagCategory1->tags();
        $this->assertEquals(5, $tagsFromRelationship->count());
        foreach($tags1 as $tag) {
            $this->assertTrue($tag->is($tagsFromRelationship->shift()));
        }
    }
}