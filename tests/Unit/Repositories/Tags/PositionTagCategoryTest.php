<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Tags;

use BristolSU\ControlDB\Models\Position;
use BristolSU\ControlDB\Models\Tags\PositionTag;
use BristolSU\ControlDB\Models\Tags\PositionTagCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use BristolSU\Tests\ControlDB\TestCase;

class PositionTagCategoryTest extends TestCase
{

    /** @test */
    public function getById_returns_a_position_tag_category_model_with_the_corresponding_id(){
        $positionTagCategory = PositionTagCategory::factory()->create(['id' => 2]);
        $positionTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTagCategory();
        $this->assertTrue(
            $positionTagCategory->is($positionTagCategoryRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_position_tag_category_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $positionTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTagCategory();
        $positionTagCategoryRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_position_tags_categories(){
        $positionTagCategories = PositionTagCategory::factory()->count(15)->create();
        $positionTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTagCategory();
        $allTagCategories = $positionTagCategoryRepo->all();
        $this->assertInstanceOf(Collection::class, $allTagCategories);
        foreach($positionTagCategories as $positionTagCategory) {
            $this->assertTrue($positionTagCategory->is(
                $allTagCategories->shift()
            ));
        }
    }

    /** @test */
    public function getByReference_returns_a_tag_category_given_the_full_reference(){
        $positionTagCategory = PositionTagCategory::factory()->create(['reference' => 'ref1']);

        $positionTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTagCategory();
        $positionTagCategoryFromRepo = $positionTagCategoryRepo->getByReference('ref1');
        $this->assertInstanceOf(PositionTagCategory::class, $positionTagCategoryFromRepo);
        $this->assertTrue($positionTagCategory->is($positionTagCategoryFromRepo));

    }

    /** @test */
    public function getByReference_throws_an_exception_if_position_tag_category_not_found(){
        $this->expectException(ModelNotFoundException::class);
        $positionTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTagCategory();
        $positionTagCategoryRepo->getByReference('notavalidref');
    }

    /** @test */
    public function create_creates_a_position_tag_category_model(){
        $positionTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTagCategory();
        $positionTagCategoryRepo->create('Name', 'Description', 'reference');

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'Name',
            'description' => 'Description',
            'reference' => 'reference',
        ]);
    }

    /** @test */
    public function create_returns_a_position_tag_category_model(){
        $positionTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTagCategory();
        $positionTagCategory = $positionTagCategoryRepo->create('Name', 'Description', 'reference');

        $this->assertInstanceOf(PositionTagCategory::class, $positionTagCategory);
        $this->assertEquals('Name', $positionTagCategory->name());
        $this->assertEquals('Description', $positionTagCategory->description());
        $this->assertEquals('reference', $positionTagCategory->reference());
    }

    /** @test */
    public function delete_deletes_a_position_tag_category_model(){
        $positionTagCategory = PositionTagCategory::factory()->create();
        $positionTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\PositionTagCategory();
        $positionTagCategoryRepo->delete($positionTagCategory->id());

        $positionTagCategory->refresh();
        $this->assertTrue($positionTagCategory->trashed());
    }

    /** @test */
    public function update_updates_a_position_tag_category()
    {
        $positionTagCategory = PositionTagCategory::factory()->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
        ]);
        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $positionTagCategory->id(),
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'type' => 'position'
        ]);
        $repository = new \BristolSU\ControlDB\Repositories\Tags\PositionTagCategory();
        $repository->update($positionTagCategory->id(), 'TagCategoryName2',  'TagCategoryDesc2', 'ref2');
        $this->assertDatabaseMissing('control_tag_categories', [
            'id' => $positionTagCategory->id(),
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'type' => 'position'
        ]);
        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $positionTagCategory->id(),
            'name' => 'TagCategoryName2',
            'description' => 'TagCategoryDesc2',
            'reference' => 'ref2',
            'type' => 'position'
        ]);

    }

    /** @test */
    public function update_returns_the_updated_position_tag_category()
    {
        $positionTagCategory = PositionTagCategory::factory()->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
        ]);
        $this->assertEquals('TagCategoryName', $positionTagCategory->name());
        $this->assertEquals('TagCategoryDesc', $positionTagCategory->description());
        $this->assertEquals('ref', $positionTagCategory->reference());

        $repository = new \BristolSU\ControlDB\Repositories\Tags\PositionTagCategory();
        $updatedPositionTagCategory = $repository->update($positionTagCategory->id(), 'TagCategoryName2', 'TagCategoryDesc2', 'ref2');

        $this->assertEquals('TagCategoryName2', $updatedPositionTagCategory->name());
        $this->assertEquals('TagCategoryDesc2', $updatedPositionTagCategory->description());
        $this->assertEquals('ref2', $updatedPositionTagCategory->reference());

    }


}
