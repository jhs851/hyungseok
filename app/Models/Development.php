<?php

namespace App\Models;

use App\Core\Favoritable;
use App\Filters\DevelopmentFilters;
use Illuminate\Database\Eloquent\{Builder, Model, Relations\BelongsTo, Relations\HasMany};

class Development extends Model
{
    use Favoritable;

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
    public function scopeFilter(Builder $query, DevelopmentFilters $filters) : Builder
    {
        return $filters->apply($query);
    }
}
