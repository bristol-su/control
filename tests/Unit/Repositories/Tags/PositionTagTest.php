<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Tags;

use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagTest extends TestCase
{

    /** @test */
    public function getById_returns_a_position_tag_model_with_the_corresponding_id(){
        $positionTag = PositionTag::factory()->create(['id' => 2]);
        $positionTagRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $this->assertTrue(
            $positionTag->is($positionTagRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_position_tag_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $positionTagRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $positionTagRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_position_tags(){
        $positionTags = PositionTag::factory()->count(15)->create();
        $positionTagRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $allTags = $positionTagRepo->all();
        $this->assertInstanceOf(Collection::class, $allTags);
        foreach($positionTags as $positionTag) {
            $this->assertTrue($positionTag->is(
                $allTags->shift()
            ));
        }
    }

    /** @test */
    public function getTagByFullReference_returns_a_tag_given_the_full_reference(){
        $positionTagCategory = PositionTagCategory::factory()->create(['reference' => 'ref1']);
        $positionTag = PositionTag::factory()->create(['reference' => 'ref2', 'tag_category_id' => $positionTagCategory]);

        $positionTagRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $positionTagFromRepo = $positionTagRepo->getTagByFullReference('ref1.ref2');
        $this->assertInstanceOf(PositionTag::class, $positionTagFromRepo);
        $this->assertTrue($positionTag->is($positionTagFromRepo));

    }

    /** @test */
    public function getTagByFullReference_throws_an_exception_if_position_tag_not_found(){
        $this->expectException(ModelNotFoundException::class);
        $positionTagRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $positionTagRepo->getTagByFullReference('nota.validref');
    }

    /** @test */
    public function create_creates_a_position_tag_model(){
        $positionTagRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $positionTagRepo->create('Name', 'Description', 'reference', 1);

        $this->assertDatabaseHas('control_tags', [
            'name' => 'Name',
            'description' => 'Description',
            'reference' => 'reference',
            'tag_category_id' => 1
        ]);
    }

    /** @test */
    public function create_returns_a_position_tag_model(){
        $positionTagRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $positionTag = $positionTagRepo->create('Name', 'Description', 'reference', 1);

        $this->assertInstanceOf(PositionTag::class, $positionTag);
        $this->assertEquals('Name', $positionTag->name());
        $this->assertEquals('Description', $positionTag->description());
        $this->assertEquals('reference', $positionTag->reference());
        $this->assertEquals(1, $positionTag->categoryId());
    }

    /** @test */
    public function delete_deletes_a_position_tag_model(){
        $positionTag = PositionTag::factory()->create();
        $positionTagRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $positionTagRepo->delete($positionTag->id());

        $positionTag->refresh();
        $this->assertTrue($positionTag->trashed());
    }

    /** @test */
    public function allThroughTagCategory_returns_all_tags_through_a_tag_category(){
        $category = PositionTagCategory::factory()->create();
        $tags = PositionTag::factory()->count(10)->create(['tag_category_id' => $category->id()]);
        PositionTag::factory()->count(10)->create();

        $positionTagRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $tagsFromRepo = $positionTagRepo->allThroughTagCategory($category);
        $this->assertContainsOnlyInstancesOf(PositionTag::class, $tagsFromRepo);
        foreach($tags as $tag) {
            $this->assertTrue($tag->is(
                $tagsFromRepo->shift()
            ));
        }
    }

    /** @test */
    public function update_updates_a_position_tag_category()
    {
        $oldTagCategory = PositionTagCategory::factory()->create();
        $newTagCategory = PositionTagCategory::factory()->create();
        $positionTag = PositionTag::factory()->create([
            'name' => 'TagName',
            'description' => 'TagDesc',
            'reference' => 'ref',
            'tag_category_id' => $oldTagCategory->id
        ]);
        $this->assertDatabaseHas('control_tags', [
            'id' => $positionTag->id(),
            'name' => 'TagName',
            'description' => 'TagDesc',
            'reference' => 'ref',
            'tag_category_id' => (string) $oldTagCategory->id,
        ]);
        $repository = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $repository->update($positionTag->id(), 'TagName2',  'TagDesc2', 'ref2', $newTagCategory->id());
        $this->assertDatabaseMissing('control_tags', [
            'id' => $positionTag->id(),
            'name' => 'TagName',
            'description' => 'TagDesc',
            'reference' => 'ref',
            'tag_category_id' => (string) $oldTagCategory->id,
        ]);
        $this->assertDatabaseHas('control_tags', [
            'id' => $positionTag->id(),
            'name' => 'TagName2',
            'description' => 'TagDesc2',
            'reference' => 'ref2',
            'tag_category_id' => (string) $newTagCategory->id,
        ]);

    }

    /** @test */
    public function update_returns_the_updated_position_tag_category()
    {
        $oldTagCategory = PositionTagCategory::factory()->create();
        $newTagCategory = PositionTagCategory::factory()->create();
        $positionTag = PositionTag::factory()->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'tag_category_id' => $oldTagCategory->id()
        ]);
        $this->assertEquals('TagCategoryName', $positionTag->name());
        $this->assertEquals('TagCategoryDesc', $positionTag->description());
        $this->assertEquals('ref', $positionTag->reference());
        $this->assertEquals($oldTagCategory->id(), $positionTag->categoryId());

        $repository = new \BristolSU\ControlDB\Repositories\Tags\PositionTag();
        $updatedPositionTag = $repository->update($positionTag->id(), 'TagCategoryName2', 'TagCategoryDesc2', 'ref2', $newTagCategory->id());

        $this->assertEquals('TagCategoryName2', $updatedPositionTag->name());
        $this->assertEquals('TagCategoryDesc2', $updatedPositionTag->description());
        $this->assertEquals('ref2', $updatedPositionTag->reference());
        $this->assertEquals($newTagCategory->id(), $updatedPositionTag->categoryId());
    }
}
