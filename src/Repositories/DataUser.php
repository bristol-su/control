<?php

namespace BristolSU\ControlDB\Repositories;

use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DataUser implements \BristolSU\ControlDB\Contracts\Repositories\DataUser
{

    /**
     * Get a data user by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return \BristolSU\ControlDB\Models\DataUser::findOrFail($id);
    }

    /**
     * Get a data user with the given attributes, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        $baseAttributes = $attributes;
        $additionalAttributes = [];
        foreach (\BristolSU\ControlDB\Models\DataUser::getAdditionalAttributes() as $property) {
            if (array_key_exists($property, $baseAttributes)) {
                $additionalAttributes[$property] = $baseAttributes[$property];
                unset($baseAttributes[$property]);
            }
        }
        $users = \BristolSU\ControlDB\Models\DataUser::where($baseAttributes)->get()->filter(function (\BristolSU\ControlDB\Models\DataUser $dataUser) use ($additionalAttributes) {
            foreach ($additionalAttributes as $additionalAttribute => $value) {
                if ($dataUser->getAdditionalAttribute($additionalAttribute) !== $value) {
                    return false;
                }
            }
            return true;
        })->values();

        if ($users->count() > 0) {
            return $users->first();
        }
        throw (new ModelNotFoundException())->setModel(DataUser::class);
    }

    /**
     * Create a new data user
     *
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string|null $email
     * @param DateTime|null $dob
     * @param string|null $preferredName
     * @return \BristolSU\ControlDB\Contracts\Models\DataUser
     */
    public function create(?string $firstName = null, ?string $lastName = null, ?string $email = null, ?DateTime $dob = null, ?string $preferredName = null): \BristolSU\ControlDB\Contracts\Models\DataUser
    {
        return \BristolSU\ControlDB\Models\DataUser::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'dob' => $dob,
            'preferred_name' => $preferredName
        ]);
    }
}