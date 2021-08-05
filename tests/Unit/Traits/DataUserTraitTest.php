<?php

namespace BristolSU\Tests\ControlDB\Unit\Traits;

use BristolSU\ControlDB\Models\DataUser;
use BristolSU\ControlDB\Models\User;
use BristolSU\Tests\ControlDB\TestCase;
use Carbon\Carbon;

class DataUserTraitTest extends TestCase
{
    /** @test */
    public function user_returns_the_user(){
        $dataUser = DataUser::factory()->create();
        $user = User::factory()->create(['data_provider_id' => $dataUser->id()]);

        $this->assertInstanceOf(User::class, $dataUser->user());
        $this->assertTrue($user->is($dataUser->user()));
    }

    /** @test */
    public function it_returns_null_if_no_user_found(){
        $dataUser = DataUser::factory()->create();
        $this->assertNull($dataUser->user());
    }

    /** @test */
    public function setFirstName_updates_the_first_name()
    {
        $dob = Carbon::create(1977, 05, 11);
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'email@example.com',
            'dob' => $dob,
            'preferred_name' => 'Toby Tw'
        ]);
        $dataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $dataUserRepo->update($dataUser->id(), 'Toby2', 'Twigger', 'email@example.com', $dob, 'Toby Tw')->shouldBeCalled()->willReturn($dataUser);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class, $dataUserRepo->reveal());

        $dataUser->setFirstName('Toby2');
    }

    /** @test */
    public function setName_updates_the_name()
    {
        $dob = Carbon::create(1977, 05, 11);
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'email@example.com',
            'dob' => $dob,
            'preferred_name' => 'Toby Tw'
        ]);
        $dataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $dataUserRepo->update($dataUser->id(), 'Toby', 'Twigger2', 'email@example.com', $dob, 'Toby Tw')->shouldBeCalled()->willReturn($dataUser);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class, $dataUserRepo->reveal());

        $dataUser->setLastName('Twigger2');
    }

    /** @test */
    public function setEmail_updates_the_email()
    {
        $dob = Carbon::create(1977, 05, 11);
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'email@example.com',
            'dob' => $dob,
            'preferred_name' => 'Toby Tw'
        ]);
        $dataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $dataUserRepo->update($dataUser->id(), 'Toby', 'Twigger', 'email2@example.com', $dob, 'Toby Tw')->shouldBeCalled()->willReturn($dataUser);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class, $dataUserRepo->reveal());

        $dataUser->setEmail('email2@example.com');
    }

    /** @test */
    public function setDob_updates_the_dob()
    {
        $dob = Carbon::create(1977, 05, 11);
        $newDob = Carbon::create(1988, 05, 11);
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'email@example.com',
            'dob' => $dob,
            'preferred_name' => 'Toby Tw'
        ]);
        $dataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $dataUserRepo->update($dataUser->id(), 'Toby', 'Twigger', 'email@example.com', $newDob, 'Toby Tw')->shouldBeCalled()->willReturn($dataUser);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class, $dataUserRepo->reveal());

        $dataUser->setDob($newDob);
    }

    /** @test */
    public function setPreferredName_updates_the_preferred_name()
    {
        $dob = Carbon::create(1977, 05, 11);
        $dataUser = DataUser::factory()->create([
            'first_name' => 'Toby',
            'last_name' => 'Twigger',
            'email' => 'email@example.com',
            'dob' => $dob,
            'preferred_name' => 'Toby Tw'
        ]);
        $dataUserRepo = $this->prophesize(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class);
        $dataUserRepo->update($dataUser->id(), 'Toby', 'Twigger', 'email@example.com', $dob, 'Toby Tw2')->shouldBeCalled()->willReturn($dataUser);
        $this->instance(\BristolSU\ControlDB\Contracts\Repositories\DataUser::class, $dataUserRepo->reveal());

        $dataUser->setPreferredName('Toby Tw2');
    }
}
