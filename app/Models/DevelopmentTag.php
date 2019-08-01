<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\{BelongsTo, Pivot};

class DevelopmentTag extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

       static::created(function (Pivot $pivot) {
           $pivot->tag->increment('mentions');
       });

       static::deleted(function (Pivot $pivot) {
           if ($pivot->tag->exists) {
               $pivot->tag->decrement('mentions');
           }
       });
    }

    /**
     * Tag에 대한 BelongTo 인스턴스를 반환합니다.
     *
     * @return BelongsTo
     */
    public function tag() : BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}
