<?php

namespace App\Models;

use App\Core\{Favoritable, NumericalStatementable, RecordsActivity};
use App\Events\DevelopmentRecivedNewComment;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo, Relations\BelongsToMany, Relations\HasMany};

class Development extends Model
{
    use Favoritable, RecordsActivity, Searchable, NumericalStatementable;

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

        static::created(function (Development $development) {
            if ($development->user->temporaryDevelopment) {
                $development->user->temporaryDevelopment->delete();
            }
        });

        static::deleting(function (Development $development) {
            $development->comments->each->delete();

            $development->tags->each->detach();
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
        return $this->belongsToMany(Tag::class)
            ->withTimestamps()
            ->using(DevelopmentTag::class);
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
        $array = $this->fresh()->toArray();

        // algolia 프리티어는 한 객체의 크기를 제한합니다.
        $array['body'] = Str::limit($array['body'], 400);

        return $array + ['created_at_timestamp' => $this->created_at->timestamp];
    }
}
