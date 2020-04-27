<?php

namespace BristolSU\ControlDB\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class DataGroup implements \BristolSU\ControlDB\Contracts\Repositories\DataGroup
{

    /**
     * Get a data group by ID
     * 
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return \BristolSU\ControlDB\Models\DataGroup::findOrFail($id);
    }

    /**
     * Get a data group with the given attributes, including additional attributes.
     * 
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        $groups = $this->getAllWhere($attributes);
        
        if($groups->count() > 0) {
            return $groups->first();
        }
        throw (new ModelNotFoundException())->setModel(DataGroup::class);
    }

    /**
     * Create a new data group
     * 
     * @param string|null $name
     * @param string|null $email
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function create(?string $name = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        return \BristolSU\ControlDB\Models\DataGroup::create([
            'name' => $name,
            'email' => $email,
        ]);
    }

    /**
     * Get all data groups where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection
     */
    public function getAllWhere($attributes = []): Collection
    {
        $baseAttributes = $attributes;
        $additionalAttributes = [];
        foreach (\BristolSU\ControlDB\Models\DataGroup::getAdditionalAttributes() as $property) {
            if (array_key_exists($property, $baseAttributes)) {
                $additionalAttributes[$property] = $baseAttributes[$property];
                unset($baseAttributes[$property]);
            }
        }
        return \BristolSU\ControlDB\Models\DataGroup::where(function($query) use ($baseAttributes) {
            foreach($baseAttributes as $key => $value) {
                $query = $query->orWhere($key, 'LIKE', '%' . $value . '%');
            }
            return $query;
        })->get()->filter(function (\BristolSU\ControlDB\Models\DataGroup $dataGroup) use ($additionalAttributes) {
            foreach ($additionalAttributes as $additionalAttribute => $value) {
                if ($dataGroup->getAdditionalAttribute($additionalAttribute) !== $value) {
                    return false;
                }
            }
            return true;
        })->values();
    }

    /**
     * Update a group with the given attributes
     *
     * @param int $id
     * @param string|null $name Name of the group
     * @param string|null $email Email of the group
     * @return \BristolSU\ControlDB\Contracts\Models\DataGroup
     */
    public function update(int $id, ?string $name = null, ?string $email = null): \BristolSU\ControlDB\Contracts\Models\DataGroup
    {
        $dataGroup = $this->getById($id)->fill([
            'name' => $name, 'email' => $email
        ]);
        $dataGroup->save();
        return $dataGroup;
    }
}