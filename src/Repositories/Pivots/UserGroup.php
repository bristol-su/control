<?php

namespace BristolSU\ControlDB\Repositories\Pivots;

use BristolSU\ControlDB\Contracts\Models\Group;
use BristolSU\ControlDB\Contracts\Models\User;
use BristolSU\ControlDB\Models\Pivots\UserGroup as UserGroupPivotModel;
use Illuminate\Support\Collection;

/**
 * Handle the relationship between a group and a user
 */
class UserGroup implements \BristolSU\ControlDB\Contracts\Repositories\Pivots\UserGroup
{
    
    /**
     * @inheritDoc
     */
    public function getUsersThroughGroup(Group $group): Collection
    {
        $userRepository = app(\BristolSU\ControlDB\Contracts\Repositories\User::class);

        return UserGroupPivotModel::where('group_id', $group->id())->get()->map(function(UserGroupPivotModel $userGroup) use ($userRepository) {
            return $userRepository->getById((int) $userGroup->user_id);
        })->unique(function(User $user) {
            return $user->id();
        })->values();
    }

    /**
     * @inheritDoc
     */
    public function getGroupsThroughUser(User $user): Collection
    {
        $groupRepository = app(\BristolSU\ControlDB\Contracts\Repositories\Group::class);

        return UserGroupPivotModel::where('user_id', $user->id())->get()->map(function(UserGroupPivotModel $userGroup) use ($groupRepository) {
            return $groupRepository->getById((int) $userGroup->group_id);
        })->unique(function(Group $group) {
            return $group->id();
        })->values();
    }

    /**
     * @inheritDoc
     */
    public function addUserToGroup(User $user, Group $group): void
    {
        UserGroupPivotModel::create([
            'user_id' => $user->id(), 'group_id' => $group->id()
        ]);
    }

    /**
     * @inheritDoc
     */
    public function removeUserFromGroup(User $user, Group $group): void
    {
        UserGroupPivotModel::where([
            'user_id' => $user->id(), 'group_id' => $group->id()
        ])->delete();
    }
}