<?php

namespace App\Models;

use App\Core\Searchable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Searchable;

    /**
     * 대량 할당 가능한 속성.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mentions',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleted(function (Tag $tag) {
            DevelopmentTag::where('tag_id', $tag->id)->delete();
        });
    }

    /**
     * 태그를 개발 모델과 분리 합니다.
     *
     * @return bool
     */
    public function detach() : bool
    {
        return $this->pivot->delete();
    }
}
