<?php

namespace App\Models;

use App\Core\RecordsActivity;
use Illuminate\Database\Eloquent\{Model, Relations\BelongsTo};
use Illuminate\Support\Carbon;

class Comment extends Model
{
    use RecordsActivity;

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
        'development',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'isBest',
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

    /**
     * 댓글이 현재 시간의 1분 안에 생성되었는지 확인합니다.
     *
     * @return bool
     */
    public function wasJustPublished() : bool
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    /**
     * 언급된 사용자들을 반환합니다.
     *
     * @return array
     */
    public function mentionedUsers() : array
    {
        preg_match_all($this->mentionPattern(), $this->body, $matches);

        return $matches[1];
    }

    /**
     * body 컬럼의 setMutator 입니다.
     *
     * @param  string|null  $body
     */
    public function setBodyAttribute(?string $body) : void
    {
        $this->attributes['body'] = preg_replace_callback(
            $this->mentionPattern(),
            [$this, 'wrapAnchorTag'],
            $body
        );
    }

    /**
     * 언급을 구분하는 패턴을 반환합니다.
     *
     * @return string
     */
    protected function mentionPattern() : string
    {
        return '/@([\w\-가-힣]+)/';
    }

    /**
     * 주어진 사용자의 이름을 a 태그로 감쌉니다.
     *
     * @param  array  $matches
     * @return string
     */
    protected function wrapAnchorTag(array $matches) : string
    {
        if ($user = User::where('name', $matches[1])->first()) {
            return "<a href=\"" . route('users.show', $user->id) . "\">{$matches[0]}</a>";
        }

        return $matches[0];
    }

    /**
     * 댓글이 개발 포스트의 베스트 댓글인지 확인하는 Mutator 입니다.
     *
     * @return bool
     */
    public function getIsBestAttribute() : bool
    {
        return $this->development->best_comment_id == $this->id;
    }
}
