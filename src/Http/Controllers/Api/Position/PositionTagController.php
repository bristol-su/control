<?php

namespace BristolSU\ControlDB\Http\Controllers\Api\Position;

use BristolSU\ControlDB\Http\Controllers\Controller;
use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;

class PositionTagController extends Controller
{

    public function index(Position $position)
    {
        return $position->tags();
    }

    public function update(Position $position, PositionTag $positionTag)
    {
        return $position->addTag($positionTag);
    }

    public function destroy(Position $position, PositionTag $positionTag)
    {
        $position->removeTag($positionTag);
    }

}
