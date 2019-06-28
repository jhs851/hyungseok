<?php

namespace App\Policies;

use App\Models\{User, Comment};
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * 사용자가 댓글을 만들 수 있는지 여부를 확인합니다.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if (! $lastComment = $user->fresh()->lastComment) {
            return true;
        }

        return ! $lastComment->wasJustPublished();
    }

    /**
     * 사용자가 Comment를 업데이트할 수 있는지 확인합니다.
     *
     * @param  User  $user
     * @param  Comment  $comment
     * @return bool
     */
    public function update(User $user, Comment $comment) : bool
    {
        return $user->id == $comment->user_id;
    }
}
