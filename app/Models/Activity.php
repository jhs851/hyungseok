<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo, Relations\MorphTo};

class Activity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'user_id',
    ];

    /**
     * 현재 Activity를 소유한 모델의 MorphTo 인스턴스를 반환합니다.
     *
     * @return MorphTo
     */
    public function subject() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * User 모델에 대한 BelongsTo 인스턴스를 반환합니다.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
