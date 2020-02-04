<?php


namespace BristolSU\ControlDB\Repositories;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class DataRole implements \BristolSU\ControlDB\Contracts\Repositories\DataRole
{

    /**
     * Get a data role by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return \BristolSU\ControlDB\Models\DataRole::findOrFail($id);
    }

    /**
     * Get a data role with the given attributes, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        $baseAttributes = $attributes;
        $additionalAttributes = [];
        foreach(\BristolSU\ControlDB\Models\DataRole::getAdditionalAttributes() as $property) {
            if(array_key_exists($property, $baseAttributes)) {
                $additionalAttributes[$property] = $baseAttributes[$property];
                unset($baseAttributes[$property]);
            }
        }
        $users = \BristolSU\ControlDB\Models\DataRole::where($baseAttributes)->get()->filter(function(\BristolSU\ControlDB\Models\DataRole $dataRole) use ($additionalAttributes) {
            foreach($additionalAttributes as $additionalAttribute => $value) {
                if($dataRole->getAdditionalAttribute($additionalAttribute) !== $value) {
                    return false;
                }
            }
            return true;
        })->values();

        if($users->count() > 0) {
            return $users->first();
        }
        throw (new ModelNotFoundException())->setModel(DataRole::class);
    }

    /**
     * Create a new data role
     *
     * @param string|null $roleName
     * @param string|null $email
     * @return \BristolSU\ControlDB\Contracts\Models\DataRole
     */
    public function create(?string $roleName = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataRole
    {
        return \BristolSU\ControlDB\Models\DataRole::create([
            'role_name' => $roleName,
            'email' => $email,
        ]);
    }
}