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
        $positionTagCategory = factory(PositionTagCategory::class)->create(['id' => 2]);
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
        $positionTagCategories = factory(PositionTag::class, 15)->create();
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
        $positionTagCategory = factory(PositionTagCategory::class)->create(['reference' => 'ref1']);

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


}
