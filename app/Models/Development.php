<?php

namespace App\Models;

use App\Core\{Favoritable, RecordsActivity};
use App\Events\DevelopmentRecivedNewComment;
use App\Filters\DevelopmentFilters;
use Illuminate\Database\Eloquent\{Builder, Model, Relations\BelongsTo, Relations\HasMany};
use Laravel\Scout\Searchable;

class Development extends Model
{
    use Favoritable, RecordsActivity, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body',
        'best_comment_id',
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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Development $development) {
            $development->comments->each->delete();
        });
    }

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
        $comment = $this->comments()->create($comment);

        DevelopmentRecivedNewComment::dispatch($comment);

        return $comment;
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

    /**
     * 주어진 댓글을 베스트 댓글로 마크합니다.
     *
     * @param  Comment  $comment
     * @return Development
     */
    public function markBestComment(Comment $comment) : Development
    {
        $this->update(['best_comment_id' => $comment->id]);

        return $this;
    }
}
