<?php


namespace BristolSU\ControlDB\Repositories;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

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
        $positions = $this->getAllWhere($attributes);

        if($positions->count() > 0) {
            return $positions->first();
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

    /**
     * Get all data positions where the given attributes match, including additional attributes.
     *
     * @param array $attributes
     * @return Collection
     */
    public function getAllWhere($attributes = []): Collection
    {
        $baseAttributes = $attributes;
        $additionalAttributes = [];
        foreach (\BristolSU\ControlDB\Models\DataPosition::getAdditionalAttributes() as $property) {
            if (array_key_exists($property, $baseAttributes)) {
                $additionalAttributes[$property] = $baseAttributes[$property];
                unset($baseAttributes[$property]);
            }
        }
        return \BristolSU\ControlDB\Models\DataPosition::where(function($query) use ($baseAttributes) {
            foreach($baseAttributes as $key => $value) {
                $query = $query->orWhere($key, 'LIKE', '%' . $value . '%');
            }
            return $query;
        })->get()->filter(function (\BristolSU\ControlDB\Models\DataPosition $dataPosition) use ($additionalAttributes) {
            foreach ($additionalAttributes as $additionalAttribute => $value) {
                if ($dataPosition->getAdditionalAttribute($additionalAttribute) !== $value) {
                    return false;
                }
            }
            return true;
        })->values();
    }

    /**
     * Update a data position with the given attributes
     *
     * @param int $id
     * @param string|null $name Name of the position
     * @param string|null $description Description of the position
     * @return \BristolSU\ControlDB\Contracts\Models\DataPosition
     */
    public function update(int $id, ?string $name = null, ?string $description = null): \BristolSU\ControlDB\Contracts\Models\DataPosition
    {
        $dataPosition = $this->getById($id)->fill([
            'name' => $name, 'description' => $description
        ]);  
        $dataPosition->save();
        return $dataPosition;
    }
}