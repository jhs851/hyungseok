<?php

namespace App\Listeners;

use App\Notifications\DevelopmentWasUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAWriter
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event) : void
    {
        $development = $event->comment->development;

        if ($development->user_id != $event->comment->user_id) {
            $development->user->notify(new DevelopmentWasUpdated($development, $event->comment));
        }
    }
}
