<?php

namespace App\Models;

use App\Core\RecordsActivity;
use Illuminate\Database\Eloquent\{Model, Relations\MorphTo};

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
}
