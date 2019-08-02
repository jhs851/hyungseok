<?php

namespace App\Models;

use App\Core\RecordsActivity;
use Illuminate\Database\Eloquent\{Builder, Model, Relations\BelongsTo, Relations\MorphTo};

class Favorite extends Model
{
    use RecordsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * 현재 Favorite을 소유한 모델의 MorphTo 인스턴스를 반환합니다.
     *
     * @return MorphTo
     */
    public function favorited() : MorphTo
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
     * 좋아요 타입과 id로 그룹화하고 count 를 추가한 Builder를 반환합니다.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeCountByFavorited(Builder $query) : Builder
    {
        return $query->select('favorited_type', 'favorited_id')
            ->selectRaw('COUNT(*) as favorites_count')
            ->groupBy('favorited_type', 'favorited_id');
    }
}
