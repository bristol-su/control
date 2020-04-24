<?php

namespace BristolSU\Tests\ControlDB\Unit\Models;

use BristolSU\ControlDB\Models\DataRole;
use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\Role;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function id_returns_the_id_of_the_user(){
        $user = factory(User::class)->create();
        
        $this->assertEquals($user->id, $user->id());
    }
    
    /** @test */
    public function dataProviderId_returns_the_data_provider_id_of_the_model(){
        $user = factory(User::class)->create(['data_provider_id' => 5]);
        
        $this->assertEquals(5, $user->dataProviderId());
    }

    /** @test */
    public function a_data_provider_id_can_set_on_from_the_model(){
        $user = factory(User::class)->create([
            'data_provider_id' => 5
        ]);

        $user->setDataProviderId(6);

        $this->assertEquals(6, $user->dataProviderId());
    }

    /** @test */
    public function data_is_returned_in_the_array(){
        $dataUser = factory(DataUser::class)->create(
            ['first_name' => 'Jane', 'email' => 'test@testing.com']
        );
        $user = factory(User::class)->create([
            'data_provider_id' => $dataUser->id()
        ]);

        $attributes = $user->toArray();
        $this->assertArrayHasKey('data', $attributes);
        $this->assertIsArray($attributes['data']);
        $this->assertArrayHasKey('first_name', $attributes['data']);
        $this->assertArrayHasKey('email', $attributes['data']);
        $this->assertEquals('Jane', $attributes['data']['first_name']);
        $this->assertEquals('test@testing.com', $attributes['data']['email']);
    }

    /** @test */
    public function data_is_returned_in_the_array_including_additional_attributes(){
        DataUser::addProperty('student_id');
        $dataUser = factory(DataUser::class)->create(
            ['first_name' => 'Jane', 'email' => 'test@testing.com']
        );
        $dataUser->student_id = 'xy123456';
        $dataUser->save();
        $user = factory(User::class)->create([
            'data_provider_id' => $dataUser->id()
        ]);

        $attributes = $user->toArray();
        $this->assertArrayHasKey('data', $attributes);
        $this->assertIsArray($attributes['data']);
        $this->assertArrayHasKey('first_name', $attributes['data']);
        $this->assertArrayHasKey('email', $attributes['data']);
        $this->assertArrayHasKey('student_id', $attributes['data']);
        $this->assertEquals('Jane', $attributes['data']['first_name']);
        $this->assertEquals('test@testing.com', $attributes['data']['email']);
        $this->assertEquals('xy123456', $attributes['data']['student_id']);
    }

}
