<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Collection, Model, Relations\BelongsTo, Relations\MorphTo};

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
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'subject',
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

    /**
     * 주어진 사용자의 활동 내역을 타입 별로 그룹화해서 반환합니다.
     *
     * @param  User  $user
     * @param  int  $take
     * @return Collection
     */
    public static function feed(User $user, int $take = 50) : Collection
    {
        return static::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take($take)
            ->get()
            ->groupBy(function ($activity) {
                return $activity->type;
            });
    }
}
