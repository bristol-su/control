<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\User;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\User\StoreRoleRequest;
use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepository;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use BristolSU\ControlDB\Contracts\Models\User;

class UserController extends Controller
{
    public function index(UserRepository $userRepository)
    {
        return $userRepository->all();
    }

    public function show(User $user)
    {
        return $user;
    }

    public function store(StoreRoleRequest $request, UserRepository $userRepository, DataUserRepository $dataUserRepository)
    {
        $dataUser = $dataUserRepository->create(
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('email'),
            \DateTime::createFromFormat('d-m-Y', $request->input('dob')),
            $request->input('preferred_name')
        );

        return $userRepository->create($dataUser->id());
    }

    public function update(User $user, StoreRoleRequest $request, UserRepository $userRepository, DataUserRepository $dataUserRepository)
    {
        $dataUser = $user->data();

        if($request->input('first_name') !== null) {
            $dataUser->setFirstName($request->input('first_name'));
        }
        if($request->input('last_name') !== null) {
            $dataUser->setLastName($request->input('last_name'));
        }
        if($request->input('email') !== null) {
            $dataUser->setEmail($request->input('email'));
        }
        if($request->input('dob') !== null) {
            $dataUser->setDob(\DateTime::createFromFormat('d-m-Y', $request->input('dob')));
        }
        if($request->input('preferred_name') !== null) {
            $dataUser->setPreferredName($request->input('preferred_name'));
        }


        return $user;
    }

    public function destroy(User $user, UserRepository $userRepository)
    {
        $userRepository->delete((int) $user->id());
    }


}
