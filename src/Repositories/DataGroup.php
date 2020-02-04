<?php

namespace BristolSU\ControlDB\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        $baseAttributes = $attributes;
        $additionalAttributes = [];
        foreach(\BristolSU\ControlDB\Models\DataGroup::getAdditionalAttributes() as $property) {
            if(array_key_exists($property, $baseAttributes)) {
                $additionalAttributes[$property] = $baseAttributes[$property];
                unset($baseAttributes[$property]);
            }
        }
        $users = \BristolSU\ControlDB\Models\DataGroup::where($baseAttributes)->get()->filter(function(\BristolSU\ControlDB\Models\DataGroup $dataGroup) use ($additionalAttributes) {
            foreach($additionalAttributes as $additionalAttribute => $value) {
                if($dataGroup->getAdditionalAttribute($additionalAttribute) !== $value) {
                    return false;
                }
            }
            return true;
        })->values();
        
        if($users->count() > 0) {
            return $users->first();
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
}