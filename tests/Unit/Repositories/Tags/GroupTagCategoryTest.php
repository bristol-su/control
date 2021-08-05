<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Tags;

use BristolSU\ControlDB\Models\Group;
use BristolSU\ControlDB\Models\Tags\GroupTag;
use BristolSU\ControlDB\Models\Tags\GroupTagCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use BristolSU\Tests\ControlDB\TestCase;

class GroupTagCategoryTest extends TestCase
{

    /** @test */
    public function getById_returns_a_group_tag_category_model_with_the_corresponding_id(){
        $groupTagCategory = GroupTagCategory::factory()->create(['id' => 2]);
        $groupTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTagCategory();
        $this->assertTrue(
            $groupTagCategory->is($groupTagCategoryRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_group_tag_category_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $groupTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTagCategory();
        $groupTagCategoryRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_group_tags_categories(){
        $groupTagCategories = GroupTagCategory::factory()->count(15)->create();
        $groupTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTagCategory();
        $allTagCategories = $groupTagCategoryRepo->all();

        $this->assertInstanceOf(Collection::class, $allTagCategories);
        foreach($groupTagCategories as $groupTagCategory) {
            $this->assertTrue($groupTagCategory->is(
                $allTagCategories->shift()
            ));
        }
    }

    /** @test */
    public function getByReference_returns_a_tag_category_given_the_full_reference(){
        $groupTagCategory = GroupTagCategory::factory()->create(['reference' => 'ref1']);

        $groupTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTagCategory();
        $groupTagCategoryFromRepo = $groupTagCategoryRepo->getByReference('ref1');
        $this->assertInstanceOf(GroupTagCategory::class, $groupTagCategoryFromRepo);
        $this->assertTrue($groupTagCategory->is($groupTagCategoryFromRepo));

    }

    /** @test */
    public function getByReference_throws_an_exception_if_group_tag_category_not_found(){
        $this->expectException(ModelNotFoundException::class);
        $groupTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTagCategory();
        $groupTagCategoryRepo->getByReference('notavalidref');
    }

    /** @test */
    public function create_creates_a_group_tag_category_model(){
        $groupTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTagCategory();
        $groupTagCategoryRepo->create('Name', 'Description', 'reference');

        $this->assertDatabaseHas('control_tag_categories', [
            'name' => 'Name',
            'description' => 'Description',
            'reference' => 'reference',
        ]);
    }

    /** @test */
    public function create_returns_a_group_tag_category_model(){
        $groupTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTagCategory();
        $groupTagCategory = $groupTagCategoryRepo->create('Name', 'Description', 'reference');

        $this->assertInstanceOf(GroupTagCategory::class, $groupTagCategory);
        $this->assertEquals('Name', $groupTagCategory->name());
        $this->assertEquals('Description', $groupTagCategory->description());
        $this->assertEquals('reference', $groupTagCategory->reference());
    }

    /** @test */
    public function delete_deletes_a_group_tag_category_model(){
        $groupTagCategory = GroupTagCategory::factory()->create();
        $groupTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\GroupTagCategory();
        $groupTagCategoryRepo->delete($groupTagCategory->id());

        $groupTagCategory->refresh();
        $this->assertTrue($groupTagCategory->trashed());
    }

    /** @test */
    public function update_updates_a_group_tag_category()
    {
        $groupTagCategory = GroupTagCategory::factory()->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
        ]);
        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $groupTagCategory->id(),
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'type' => 'group'
        ]);
        $repository = new \BristolSU\ControlDB\Repositories\Tags\GroupTagCategory();
        $repository->update($groupTagCategory->id(), 'TagCategoryName2',  'TagCategoryDesc2', 'ref2');
        $this->assertDatabaseMissing('control_tag_categories', [
            'id' => $groupTagCategory->id(),
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
            'type' => 'group'
        ]);
        $this->assertDatabaseHas('control_tag_categories', [
            'id' => $groupTagCategory->id(),
            'name' => 'TagCategoryName2',
            'description' => 'TagCategoryDesc2',
            'reference' => 'ref2',
            'type' => 'group'
        ]);

    }

    /** @test */
    public function update_returns_the_updated_group_tag_category()
    {
        $groupTagCategory = GroupTagCategory::factory()->create([
            'name' => 'TagCategoryName',
            'description' => 'TagCategoryDesc',
            'reference' => 'ref',
        ]);
        $this->assertEquals('TagCategoryName', $groupTagCategory->name());
        $this->assertEquals('TagCategoryDesc', $groupTagCategory->description());
        $this->assertEquals('ref', $groupTagCategory->reference());

        $repository = new \BristolSU\ControlDB\Repositories\Tags\GroupTagCategory();
        $updatedGroupTagCategory = $repository->update($groupTagCategory->id(), 'TagCategoryName2', 'TagCategoryDesc2', 'ref2');

        $this->assertEquals('TagCategoryName2', $updatedGroupTagCategory->name());
        $this->assertEquals('TagCategoryDesc2', $updatedGroupTagCategory->description());
        $this->assertEquals('ref2', $updatedGroupTagCategory->reference());

    }
}
