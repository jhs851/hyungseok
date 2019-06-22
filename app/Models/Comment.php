<?php

namespace App\Models;

use App\Core\RecordActivity;
use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo};

class Comment extends Model
{
    use RecordActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'body',
    ];

    /**
     * 모든 쿼리에 빠르게 로드되는 관계.
     *
     * @var array
     */
    protected $with = [
        'user',
    ];

    /**
     * User에 대한 BelongsTo 인스턴스를 반환합니다.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 개발 모델에 대한 BelongsTo 인스턴스를 반환합니다.
     *
     * @return BelongsTo
     */
    public function development() : BelongsTo
    {
        return $this->belongsTo(Development::class);
    }
}
