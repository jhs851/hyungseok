<?php

namespace App\Models;

use App\Filters\DevelopmentFilters;
use Illuminate\Database\Eloquent\{Builder, Model, Relations\BelongsTo, Relations\HasMany, Relations\MorphMany};

class Development extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
    ];

    /**
     * 직렬화에서 볼 수 있는 속성.
     *
     * @var array
     */
    protected $visible = [
        'title',
        'body',
        'comments_count',
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
     * 모든 쿼리에 빠르게 로드되어야 하는 관계의 카운트.
     *
     * @var array
     */
    protected $withCount = [
        'comments',
        'favorites',
    ];

    /**
     * User 에 대한 BelongsTo 인스턴스를 반환합니다.
     *
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Comment에 대한 HasMany 인스턴스를 반환합니다.
     *
     * @return HasMany
     */
    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Favorite에 대한 MorphMany 인스턴스를 반환합니다.
     *
     * @return MorphMany
     */
    public function favorites() : MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * 개발 포스트에 '좋아요'를 합니다.
     *
     * @return Favorite|null
     */
    public function favorite() : ?Favorite
    {
        $attributes = ['user_id' => auth()->id()];

        if ($this->favorites()->where($attributes)->exists()) {
            return null;
        }

        return $this->favorites()->create($attributes);
    }

    /**
     * 현재 사용자가 좋아료를 했는지 확인합니다.
     *
     * @return bool
     */
    public function getisFavoritedAttribute() : bool
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }

    /**
     * 댓글을 생성합니다.
     *
     * @param  array  $comment
     * @return Comment
     */
    public function addComment(array $comment) : Comment
    {
        return $this->comments()->create($comment);
    }

    /**
     * 필터링된 개발 포스트 Builder를 반환합니다.
     *
     * @param  Builder  $query
     * @param  DevelopmentFilters  $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, DevelopmentFilters $filters)
    {
        return $filters->apply($query);
    }
}
