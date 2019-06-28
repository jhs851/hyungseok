<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class YouWereMentioned extends Notification
{
    use Queueable;

    /**
     * Comment 인스턴스.
     *
     * @var Comment
     */
    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @param  Comment  $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) : array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) : array
    {
        return [
            'message' => trans('comments.mentioned', ['name' => $this->comment->user->name, 'title' => $this->comment->development->title]),
            'link' => route('developments.show', $this->comment->development->id),
        ];
    }
}
