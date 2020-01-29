<?php

namespace BristolSU\Tests\ControlDB\Integration\Http\Controllers\RoleTag;

use BristolSU\ControlDB\Models\Tags\RoleTag;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTagRoleControllerTest extends TestCase
{
    /** @test */
    public function it_gets_all_roles_through_a_tag()
    {
        $roleTag = factory(RoleTag::class)->create();
        $roles = factory(Role::class, 5)->create();

        foreach ($roles as $role) {
            $roleTag->addRole($role);
            $this->assertDatabaseHas('control_taggables', [
                'taggable_id' => $role->id(),
                'tag_id' => $roleTag->id(),
                'taggable_type' => 'role'
            ]);
        }

        $response = $this->getJson($this->apiUrl . '/role-tag/' . $roleTag->id() . '/role');
        $response->assertStatus(200);

        $response->assertJsonCount(5);
        foreach ($response->json() as $roleThroughApi) {
            $this->assertArrayHasKey('id', $roleThroughApi);
            $this->assertEquals($roles->shift()->id(), $roleThroughApi['id']);
        }
    }

    /** @test */
    public function it_tags_a_role()
    {
        $role = factory(Role::class)->create();
        $roleTag = factory(RoleTag::class)->create();

        $this->assertDatabaseMissing('control_taggables', [
            'taggable_id' => $role->id(),
            'tag_id' => $roleTag->id(),
            'taggable_type' => 'role'
        ]);

        $response = $this->patchJson(
            $this->apiUrl . '/role-tag/' . $roleTag->id() . '/role/' . $role->id()
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $role->id(),
            'tag_id' => $roleTag->id(),
            'taggable_type' => 'role'
        ]);
    }

    /** @test */
    public function it_untags_a_role()
    {
        $role = factory(Role::class)->create();
        $roleTag = factory(RoleTag::class)->create();

        $role->addTag($roleTag);

        $this->assertDatabaseHas('control_taggables', [
            'taggable_id' => $role->id(),
            'tag_id' => $roleTag->id(),
            'taggable_type' => 'role'
        ]);

        $response = $this->deleteJson(
            $this->apiUrl . '/role-tag/' . $roleTag->id() . '/role/' . $role->id()
        );

        $response->assertStatus(200);

        $this->assertSoftDeleted('control_taggables', [
            'taggable_id' => $role->id(),
            'tag_id' => $roleTag->id(),
            'taggable_type' => 'role'
        ]);


    }
}