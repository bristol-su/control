<?php

namespace BristolSU\ControlDB\Http\Controllers\User;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\User\StoreRoleRequest;
use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepository;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Http\Requests\Api\User\StoreUserRequest;
use Carbon\Carbon;

/**
 * Handle the user model
 */
class UserController extends Controller
{

    /**
     * Get all users
     * 
     * @param UserRepository $userRepository
     * @return User[]|\Illuminate\Support\Collection
     */
    public function index(UserRepository $userRepository)
    {
        return $userRepository->all();
    }

    /**
     * Get information about a specific user
     * 
     * @param User $user
     * @return User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Create a new user
     * 
     * @param StoreUserRequest $request
     * @param UserRepository $userRepository
     * @param DataUserRepository $dataUserRepository
     * @return User
     */
    public function store(StoreUserRequest $request, UserRepository $userRepository, DataUserRepository $dataUserRepository)
    {
        $dataUser = $dataUserRepository->create(
            $request->input('first_name'),
            $request->input('last_name'),
            $request->input('email'),
            Carbon::make($request->input('dob')),
            $request->input('preferred_name')
        );

        foreach($dataUser->getAdditionalAttributes() as $additionalAttribute) {
            if($request->has($additionalAttribute)) {
                $dataUser->saveAdditionalAttribute($additionalAttribute, $request->input($additionalAttribute));
            }
        }
        
        return $userRepository->create($dataUser->id());
    }

    /**
     * Update a user
     * 
     * @param User $user
     * @param StoreUserRequest $request
     * @param UserRepository $userRepository
     * @param DataUserRepository $dataUserRepository
     * @return User
     */
    public function update(User $user, StoreUserRequest $request, UserRepository $userRepository, DataUserRepository $dataUserRepository)
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
            $dataUser->setDob(Carbon::make($request->input('dob')));
        }
        if($request->input('preferred_name') !== null) {
            $dataUser->setPreferredName($request->input('preferred_name'));
        }

        foreach($dataUser->getAdditionalAttributes() as $additionalAttribute) {
            if($request->has($additionalAttribute)) {
                $dataUser->saveAdditionalAttribute($additionalAttribute, $request->input($additionalAttribute));
            }
        }

        return $user;
    }

    /**
     * Delete a user
     * 
     * @param User $user
     * @param UserRepository $userRepository
     */
    public function destroy(User $user, UserRepository $userRepository)
    {
        $userRepository->delete((int) $user->id());
    }


}
