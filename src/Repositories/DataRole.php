<?php


namespace BristolSU\ControlDB\Repositories;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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
        $roles = $this->getAllWhere($attributes);

        if($roles->count() > 0) {
            return $roles->first();
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

    /**
     * Get all data roles where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection
     */
    public function getAllWhere($attributes = []): Collection
    {
        $baseAttributes = $attributes;
        $additionalAttributes = [];
        foreach (\BristolSU\ControlDB\Models\DataRole::getAdditionalAttributes() as $property) {
            if (array_key_exists($property, $baseAttributes)) {
                $additionalAttributes[$property] = $baseAttributes[$property];
                unset($baseAttributes[$property]);
            }
        }
        return \BristolSU\ControlDB\Models\DataRole::where(function($query) use ($baseAttributes) {
            foreach($baseAttributes as $key => $value) {
                $query = $query->orWhere($key, 'LIKE', '%' . $value . '%');
            }
            return $query;
        })->get()->filter(function (\BristolSU\ControlDB\Models\DataRole $dataRole) use ($additionalAttributes) {
            foreach ($additionalAttributes as $additionalAttribute => $value) {
                if ($dataRole->getAdditionalAttribute($additionalAttribute) !== $value) {
                    return false;
                }
            }
            return true;
        })->values();
    }
}