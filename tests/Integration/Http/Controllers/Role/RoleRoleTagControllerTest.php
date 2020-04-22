<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\Role;

use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\Tests\ControlDB\TestCase;

class RoleRoleTagControllerTest extends TestCase
{

    /** @test */
    public function it_gets_all_tags_through_a_role(){
        $role = factory(Role::class)->create();
        $roleTags = factory(RoleTag::class, 5)->create();
        
        foreach($roleTags as $roleTag) {
            $role->addTag($roleTag);
            $this->assertDatabaseHas('control_taggables', [
                'taggable_id' => $role->id(),
                'tag_id' => $roleTag->id(),
                'taggable_type' => 'role'
            ]);
        }
        
        $response = $this->getJson($this->apiUrl . '/role/' . $role->id() . '/tag');
        $response->assertStatus(200);
        $response->assertPaginatedResponse();
        $response->assertPaginatedJsonCount(5);
        foreach($response->paginatedJson() as $roleTagThroughApi) {
            $this->assertArrayHasKey('id', $roleTagThroughApi);
            $this->assertEquals($roleTags->shift()->id(), $roleTagThroughApi['id']);
        }
    }
    
    /** @test */
    public function it_tags_a_role(){
        $role = factory(Role::class)->create();
        $roleTag = factory(RoleTag::class)->create();
        
        $this->assertDatabaseMissing('control_taggables', [
            'taggable_id' => $role->id(),
            'tag_id' => $roleTag->id(),
            'taggable_type' => 'role'
        ]);
        
        $response = $this->patchJson(
            $this->apiUrl . '/role/' . $role->id() . '/tag/' . $roleTag->id()
        );

        $response->assertStatus(200);
        
        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $role->id(),
            'tag_id' => $roleTag->id(),
            'taggable_type' => 'role'
        ]);
    }
    
    /** @test */
    public function it_untags_a_role(){
        $role = factory(Role::class)->create();
        $roleTag = factory(RoleTag::class)->create();

        $role->addTag($roleTag);
        
        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $role->id(),
            'tag_id' => $roleTag->id(),
            'taggable_type' => 'role'
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/role/' . $role->id() . '/tag/' . $roleTag->id()
        );

        $response->assertStatus(200);
        
        $this->assertSoftDeleted('control_taggables', [
            'taggable_id' => $role->id(),
            'tag_id' => $roleTag->id(),
            'taggable_type' => 'role'
            ]);


    }
    
}