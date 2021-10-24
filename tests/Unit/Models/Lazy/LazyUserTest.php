<?php

namespace BristolSU\Tests\ControlDB\Unit\Models\Lazy;

use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\Lazy\LazyUser;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;

class LazyUserTest extends TestCase
{

    /** @test */
    public function an_id_can_be_retrieved_from_the_model()
    {
        $user = new LazyUser(User::factory()->create(['id' => 4])->id());

        $this->assertEquals(4, $user->id());
    }

    /** @test */
    public function a_data_provider_id_can_be_retrieved_from_the_model(){
        $user = User::factory()->create([
            'data_provider_id' => 5
        ]);

        $this->assertEquals(5, $user->dataProviderId());
    }

    /** @test */
    public function a_data_provider_id_can_set_on_from_the_model(){
        $user = new LazyUser(User::factory()->create(['data_provider_id' => 1])->id());

        $user->setDataProviderId(5);

        $this->assertEquals(5, $user->dataProviderId());
    }

    /** @test */
    public function data_is_returned_in_the_array(){
        $dataUser = DataUser::factory()->create(
            ['first_name' => 'User1', 'email' => 'email@example.com']
        );
        $user = new LazyUser(User::factory()->create(['data_provider_id' => $dataUser->id()])->id());

        $attributes = $user->toArray();
        $this->assertArrayHasKey('data', $attributes);
        $this->assertIsArray($attributes['data']);
        $this->assertArrayHasKey('first_name', $attributes['data']);
        $this->assertArrayHasKey('email', $attributes['data']);
        $this->assertEquals('User1', $attributes['data']['first_name']);
        $this->assertEquals('email@example.com', $attributes['data']['email']);
    }

}
