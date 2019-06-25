<?php

namespace App\Policies;

use App\Models\{User, Comment};
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * 사용자가 Comment를 업데이트할 수 있는지 확인합니다.
     *
     * @param  User  $user
     * @param  \App\Models\Comment  $comment
     * @return bool
     */
    public function update(User $user, Comment $comment) : bool
    {
        return $user->id == $comment->user_id;
    }
}
