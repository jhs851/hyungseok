<?php

namespace App\Observers;

use App\Models\{Comment, Development};

class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        $comment->development->comments_count++;
        $comment->development->save();
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param  Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    /**
     * "deleting" 이벤트를 처리합니다.
     *
     * @param  Comment  $comment
     */
    public function deleting(Comment $comment)
    {
        if ($comment->isBest) {
            tap($comment->development, function (Development $development) {
                $development->best_comment_id = null;
                $development->save();
            });
        }
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        $comment->development->comments_count--;
        $comment->development->save();
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param  Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param  Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }
}
