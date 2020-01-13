<?php

namespace BristolSU\Tests\ControlDB\Integration\Models;

use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;

class UserTest extends TestCase
{

    /** @test */
    public function the_data_function_returns_the_data_model(){
        $dataUser = factory(DataUser::class)->create();
        $user = factory(User::class)->create(['data_provider_id' => $dataUser->id()]);
        
        $this->assertInstanceOf(DataUser::class, $user->data());
        $this->assertTrue($dataUser->is(
            $user->data()
        ));
    }

}