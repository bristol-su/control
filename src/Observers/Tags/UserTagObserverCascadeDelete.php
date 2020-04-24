<?php

namespace BristolSU\ControlDB\Observers\Tags;

use BristolSU\ControlDB\Contracts\Models\Tags\UserTag;
use BristolSU\ControlDB\Contracts\Repositories\Pivots\Tags\UserUserTag;

class UserTagObserverCascadeDelete
{

    /**
     * @var UserUserTag
     */
    private $userUserTag;

    public function __construct(UserUserTag $userUserTag)
    {
        $this->userUserTag = $userUserTag;
    }

    public function delete(UserTag $userTag)
    {
        $users = $this->userUserTag->getUsersThroughTag($userTag);
        foreach($users as $user) {
            $this->userUserTag->removeTagFromUser($userTag, $user);
        }
    }
    
}