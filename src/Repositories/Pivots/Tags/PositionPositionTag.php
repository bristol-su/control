<?php

namespace BristolSU\ControlDB\Repositories\Pivots\Tags;

use BristolSU\ControlDB\Contracts\Models\Position;
use BristolSU\ControlDB\Contracts\Models\Tags\PositionTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\PositionPositionTag as PositionPositionTagContract;
use Illuminate\Support\Collection;

/**
 * Handles the tagging of positions
 */
class PositionPositionTag implements PositionPositionTagContract
{

    /**
     * Tag a position
     *
     * @param PositionTag $positionTag Tag to tag the position with
     * @param Position $position Position to tag
     * @return void
     */
    public function addTagToPosition(PositionTag $positionTag, Position $position): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\PositionPositionTag::create([
            'tag_id' => $positionTag->id(), 'taggable_id' => $position->id()
        ]);
    }


    /**
     * Remove a tag from a position
     *
     * @param PositionTag $positionTag Tag to remove from the position
     * @param Position $position Position to remove the tag from
     * @return void
     */
    public function removeTagFromPosition(PositionTag $positionTag, Position $position): void
    {
        \BristolSU\ControlDB\Models\Pivots\Tags\PositionPositionTag::where([
            'tag_id' => $positionTag->id(), 'taggable_id' => $position->id()
        ])->delete();    
    }

    /**
     * Get all tags a position is tagged with
     *
     * @param Position $position Position to retrieve tags from
     * @return Collection|PositionTag[] Tags the position is tagged with
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
     * Get all positions tagged with a tag
     *
     * @param PositionTag $positionTag Tag to use to retrieve positions
     * @return Collection|Position[] Positions tagged with the given tag
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