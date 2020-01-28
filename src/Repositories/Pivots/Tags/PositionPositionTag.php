<?php

namespace BristolSU\ControlDB\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag as PositionPositionTagContract;
use Illuminate\Support\Collection;

class PositionPositionTag implements PositionPositionTagContract
{

    /**
     * @inheritDoc
     */
    public function addTagToPosition(PositionTag $positionTag, Position $position): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\PositionPositionTag::create([
            'tag_id' => $positionTag->id(), 'taggable_id' => $position->id()
        ]);
    }

    /**
     * @inheritDoc
     */
    public function removeTagFromPosition(PositionTag $positionTag, Position $position): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\PositionPositionTag::where([
            'tag_id' => $positionTag->id(), 'taggable_id' => $position->id()
        ])->delete();    
    }

    /**
     * @inheritDoc
     */
    public function getTagsThroughPosition(Position $position): Collection
    {
        $positionTagRepository = app(\BristolSU\ControlDB\Contracts\Repositories\Tags\PositionTag::class);

        return \BristolSU\ControlDB\Models\Pivots\Tags\PositionPositionTag::where('taggable_id', $position->id())
            ->get()->map(function(\BristolSU\ControlDB\Models\Pivots\Tags\PositionPositionTag $positionPositionTag) use ($positionTagRepository) {
            return $positionTagRepository->getById((int) $positionPositionTag->tag_id);
        })->unique(function(PositionTag $user) {
            return $user->id();
        })->values();
    }

    /**
     * @inheritDoc
     */
    public function getPositionsThroughTag(PositionTag $positionTag): Collection
    {
        $positionRepository = app(\BristolSU\ControlDB\Contracts\Repositories\Position::class);

        return \BristolSU\ControlDB\Models\Pivots\Tags\PositionPositionTag::where('tag_id', $positionTag->id())
            ->get()->map(function(\BristolSU\ControlDB\Models\Pivots\Tags\PositionPositionTag $positionPositionTag) use ($positionRepository) {
                return $positionRepository->getById((int) $positionPositionTag->taggable_id);
            })->unique(function(Position $position) {
                return $position->id();
            })->values();
    }
}