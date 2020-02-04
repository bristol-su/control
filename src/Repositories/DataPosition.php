<?php


namespace BristolSU\ControlDB\Repositories;


use Illuminate\Database\Eloquent\ModelNotFoundException;

class DataPosition implements \BristolSU\ControlDB\Contracts\Repositories\DataPosition
{

    /**
     * Get a data position by ID
     *
     * @param int $id
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getById(int $id): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return \BristolSU\ControlDB\Models\DataPosition::findOrFail($id);
    }

    /**
     * Get a data position with the given attributes, including additional attributes.
     *
     * @param array $attributes
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function getWhere($attributes = []): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        $baseAttributes = $attributes;
        $additionalAttributes = [];
        foreach(\BristolSU\ControlDB\Models\DataPosition::getAdditionalAttributes() as $property) {
            if(array_key_exists($property, $baseAttributes)) {
                $additionalAttributes[$property] = $baseAttributes[$property];
                unset($baseAttributes[$property]);
            }
        }
        $users = \BristolSU\ControlDB\Models\DataPosition::where($baseAttributes)->get()->filter(function(\BristolSU\ControlDB\Models\DataPosition $dataPosition) use ($additionalAttributes) {
            foreach($additionalAttributes as $additionalAttribute => $value) {
                if($dataPosition->getAdditionalAttribute($additionalAttribute) !== $value) {
                    return false;
                }
            }
            return true;
        })->values();

        if($users->count() > 0) {
            return $users->first();
        }
        throw (new ModelNotFoundException())->setModel(DataPosition::class);
    }

    /**
     * Create a new data position
     *
     * @param string|null $name
     * @param string|null $description
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function create(?string $name = null, ?string $description = null): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        return \BristolSU\ControlDB\Models\DataPosition::create([
            'name' => $name,
            'description' => $description,
        ]);
    }
}