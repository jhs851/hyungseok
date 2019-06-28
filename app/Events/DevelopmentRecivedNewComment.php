<?php

namespace App\Events;

use App\Models\Comment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class DevelopmentRecivedNewComment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Comment 인스턴스.
     *
     * @var Comment
     */
    public $comment;

    /**
     * Create a new event instance.
     *
     * @param  Comment  $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
