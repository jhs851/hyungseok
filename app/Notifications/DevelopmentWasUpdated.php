<?php

namespace App\Notifications;

use App\Models\{Comment, Development, User};
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class DevelopmentWasUpdated extends Notification
{
    use Queueable;

    /**
     * Development 인스턴스.
     *
     * @var Development
     */
    protected $development;

    /**
     * Comment 인스턴스.
     *
     * @var Comment
     */
    protected $comment;

    /**
     * Create a new notification instance.
     *
     * @param  Development  $development
     * @param  Comment  $comment
     */
    public function __construct(Development $development, Comment $comment)
    {
        $this->development = $development;
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  User  $notifiable
     * @return array
     */
    public function via(User $notifiable) : array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  User  $notifiable
     * @return array
     */
    public function toArray(User $notifiable) : array
    {
        return [
            'message' => trans('comments.commented', [
                'name' => $this->comment->user->name,
                'title'  => $this->development->title,
            ]),
            'link' => route('developments.show', $this->development->id),
        ];
    }
}
