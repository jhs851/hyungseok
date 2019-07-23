<?php

namespace App\Models;

use App\Core\{Favoritable, RecordsActivity};
use App\Events\DevelopmentRecivedNewComment;
use App\Filters\DevelopmentFilters;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\{Builder, Model, Relations\BelongsTo, Relations\BelongsToMany, Relations\HasMany};
use Laravel\Scout\Builder as ScoutBuilder;
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
        'favorites',
        'tags',
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

            $development->tags()->detach();
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
     * Tag에 대한 BelongsToMany 인스턴스를 반환합니다.
     *
     * @return BelongsToMany
     */
    public function tags() : BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
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
     * @return Builder|ScoutBuilder
     */
    public function scopeFilter(Builder $query, DevelopmentFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * 주어진 월에 해댕하는 개발 포스트 Builder를 반환합니다.
     *
     * @param  Builder  $query
     * @param  Carbon|null  $date
     * @return Builder
     */
    public function scopeMonthlies(Builder $query, Carbon $date = null) : Builder
    {
        if (is_null($date)) {
            $date = Carbon::now();
        }

        return $query
                ->whereYear('created_at', '=', $date->year)
                ->whereMonth('created_at', '=', $date->month);
    }

    /**
     * 일별로 그룹화하고 해당 날짜에 해당하는 포스트의 수를 반환하는 Builder를 반환합니다.
     *
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeCountsByDays(Builder $query) : Builder
    {
        return $query->monthlies()
            ->selectRaw(app()->environment('testing')
                ? 'strftime("%d", `created_at`) as day'
                : 'DAY(created_at) as day')
            ->selectRaw('COUNT(*) as posts')
            ->groupBy('day')
            ->orderBy('day', 'asc');
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

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() : array
    {
        return $this->toArray() + ['created_at_timestamp' => $this->created_at->timestamp];
    }

    /**
     * Eager 로딩 되는 관계들을 제거하고 엘로퀀트 쿼리 빌더를 반환합니다.
     *
     * @return Builder
     */
    public static function withoutAll() : Builder
    {
        return static::without((new static)->with);
    }
}
