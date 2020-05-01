<?php

namespace BristolSU\ControlDB\Http\Controllers\User;

use BristolSU\ControlDB\Contracts\Repositories\DataUser;
use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Http\Requests\Api\User\StoreUserRequest;
use BristolSU\ControlDB\Contracts\Repositories\DataUser as DataUserRepository;
use BristolSU\ControlDB\Contracts\Repositories\User as UserRepository;
use BristolSU\ControlDB\Contracts\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Handle the user model
 */
class UserController extends Controller
{

    /**
     * Get all users
     *
     * @param Request $request
     * @param UserRepository $userRepository
     * @return LengthAwarePaginator
     */
    public function index(Request $request, UserRepository $userRepository)
    {
        $perPage = $request->input('per_page', 10);
        $page = $request->input('page', 1);
        
        return $this->paginationResponse(
            $userRepository->paginate($page, $perPage),
            $userRepository->count()
        );
    }
    
    public function search(Request $request, UserRepository $userRepository, DataUserRepository $dataUserRepository)
    {
        $search = [];
        if($request->has('first_name')) {
            $search['first_name'] = $request->input('first_name');
        }
        if($request->has('last_name')) {
            $search['last_name'] = $request->input('last_name');
        }
        if($request->has('email')) {
            $search['email'] = $request->input('email');
        }
        $dataUsers = $dataUserRepository->getAllWhere($search);
        $users = new Collection();
        foreach($dataUsers as $dataUser) {
            $user = $dataUser->user();
            if($user !== null) {
                $users->push($user);
            }
        }
        
        return $this->paginate($users);
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

        $dataUserRepository->update(
            $dataUser->id(),
            $request->input('first_name', $dataUser->firstName()),
            $request->input('last_name', $dataUser->lastName()),
            $request->input('email', $dataUser->email()),
            ($request->has('dob') ? Carbon::make($request->input('dob')) :  $dataUser->dob()),
            $request->input('preferred_name', $dataUser->preferredName()),
        );
        
        foreach($dataUser->getAdditionalAttributes() as $additionalAttribute) {
            if($request->has($additionalAttribute)) {
                $dataUser->saveAdditionalAttribute($additionalAttribute, $request->input($additionalAttribute));
            }
        }

        return $userRepository->getById($user->id());
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
