<?php


namespace BristolSU\ControlDB\Repositories;


use BristolSU\ControlDB\Contracts\Models\Group as GroupModel;
use BristolSU\ControlDB\Contracts\Models\Role as RoleModel;
use BristolSU\ControlDB\Contracts\Models\User as UserModelContract;
use BristolSU\ControlDB\Contracts\Repositories\User as UserContract;
use Illuminate\Support\Collection;

/**
 * Class User
 * @package BristolSU\ControlDB\Repositories
 */
class User extends UserContract
{


    /**
     * @inheritDoc
     */
    public function getById(int $id): UserModelContract
    {
        return \BristolSU\ControlDB\Models\User::where('id', $id)->get()->first();
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return \BristolSU\ControlDB\Models\User::all();
    }

    /**
     * @inheritDoc
     */
    public function create(string $forename, string $surname, string $email): UserModelContract
    {
        // check that email is not already registered
        if (is_null(\BristolSU\ControlDB\Models\User::where('email', $email)->get()->first()))
        {
            // check entries are valid
            $validator = Validator::make(
                [
                    'forename' => $forename,
                    'surname' => $surname,
                    'email' => $email
                ],
                [
                    'forename' => 'required|min:2|max:30|alpha_dash',
                    'surname' => 'required|min:2|max:30|alpha_dash',
                    'email' => 'required|email|unique:control_users,email'
                ]);

            if ($validator->fails())
            {
                return $validator->messages();
            }
            else
            {
                // validation has passed, create the new user entry
                $new_user = new \BristolSU\ControlDB\Models\User;
                $new_user->forename = $forename;
                $new_user->surname = $surname;
                $new_user->email = $email;
                $new_user->save();

                return "Success"; // temporary response
            }
        }
        else
        {
            return "Email already registered"; // temporary response
        }
    }
}
