<?php

namespace App\Observers;

use App\Models\Development;

class DevelopmentObserver
{
    /**
     * Handle the development "created" event.
     *
     * @param  \App\Models\Development  $development
     * @return void
     */
    public function created(Development $development)
    {
        //
    }

    /**
     * Handle the development "updated" event.
     *
     * @param  \App\Models\Development  $development
     * @return void
     */
    public function updated(Development $development)
    {
        //
    }

    /**
     * Handle the development "deleting" event.
     *
     * @param  Development  $development
     */
    public function deleting(Development $development)
    {
        $development->comments->each->delete();

        $development->tags()->detach();
    }

    /**
     * Handle the development "deleted" event.
     *
     * @param  \App\Models\Development  $development
     * @return void
     */
    public function deleted(Development $development)
    {
        //
    }

    /**
     * Handle the development "restored" event.
     *
     * @param  \App\Models\Development  $development
     * @return void
     */
    public function restored(Development $development)
    {
        //
    }

    /**
     * Handle the development "force deleted" event.
     *
     * @param  \App\Models\Development  $development
     * @return void
     */
    public function forceDeleted(Development $development)
    {
        //
    }
}
