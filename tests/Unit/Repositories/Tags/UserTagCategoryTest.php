<?php

namespace BristolSU\Tests\ControlDB\Unit\Repositories\Tags;

use BristolSU\ControlDB\Models\User;
use BristolSU\ControlDB\Models\Tags\UserTag;
use BristolSU\ControlDB\Models\Tags\UserTagCategory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use BristolSU\Tests\ControlDB\TestCase;

class UserTagCategoryTest extends TestCase
{

    /** @test */
    public function getById_returns_a_user_tag_category_model_with_the_corresponding_id(){
        $userTagCategory = factory(UserTagCategory::class)->create(['id' => 2]);
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $this->assertTrue(
            $userTagCategory->is($userTagCategoryRepo->getById(2))
        );
    }

    /** @test */
    public function getById_throws_a_modelNotFoundException_if_user_tag_category_does_not_exist(){
        $this->expectException(ModelNotFoundException::class);
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $userTagCategoryRepo->getById(5);
    }

    /** @test */
    public function all_returns_all_user_tags_categories(){
        $userTagCategories = factory(UserTag::class, 15)->create();
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $allTagCategories = $userTagCategoryRepo->all();
        $this->assertInstanceOf(Collection::class, $allTagCategories);
        foreach($userTagCategories as $userTagCategory) {
            $this->assertTrue($userTagCategory->is(
                $allTagCategories->shift()
            ));
        }
    }

    /** @test */
    public function getByReference_returns_a_tag_category_given_the_full_reference(){
        $userTagCategory = factory(UserTagCategory::class)->create(['reference' => 'ref1']);

        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $userTagCategoryFromRepo = $userTagCategoryRepo->getByReference('ref1');
        $this->assertInstanceOf(UserTagCategory::class, $userTagCategoryFromRepo);
        $this->assertTrue($userTagCategory->is($userTagCategoryFromRepo));

    }

    /** @test */
    public function getByReference_throws_an_exception_if_user_tag_category_not_found(){
        $this->expectException(ModelNotFoundException::class);
        $userTagCategoryRepo = new \BristolSU\ControlDB\Repositories\Tags\UserTagCategory();
        $userTagCategoryRepo->getByReference('notavalidref');
    }


}
