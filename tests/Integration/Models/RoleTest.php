<?php

namespace BristolSU\Tests\ControlDB\Integration\Models;

use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\Role;
use BristolSU\Tests\ControlDB\TestCase;

class RoleTest extends TestCase
{

    /** @test */
    public function the_data_function_returns_the_data_model(){
        $dataRole = factory(DataRole::class)->create();
        $role = factory(Role::class)->create(['data_provider_id' => $dataRole->id()]);
        
        $this->assertInstanceOf(DataRole::class, $role->data());
        $this->assertTrue($dataRole->is(
            $role->data()
        ));
    }

}