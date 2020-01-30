<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;

class DataUserTraitTest extends TestCase
{
    /** @test */
    public function user_returns_the_user(){
        $dataUser = factory(DataUser::class)->create();
        $user = factory(User::class)->create(['data_provider_id' => $dataUser->id()]);

        $this->assertInstanceOf(User::class, $dataUser->user());
        $this->assertTrue($user->is($dataUser->user()));
    }

    /** @test */
    public function it_returns_null_if_no_user_found(){
        $dataUser = factory(DataUser::class)->create();
        $this->assertNull($dataUser->user());
    }
}