<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Core\{NumericalStatementable, Searchable};
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\{HasMany, HasOne};
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\{Hash, Storage};

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, NumericalStatementable, Searchable;

    /**
     * 대량 할당할 수 있는 특성.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path',
    ];

    /**
     * 숨겨야 하는 특성.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * 날짜로 변경해야 하는 속성.
     *
     * @var array
     */
    protected $dates = [
        'email_verfied_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'isAdmin',
        'hasVerifiedEmail',
        'avatar',
    ];

    /**
     * Development에 대한 HasMany 인스턴스를 반환합니다.
     *
     * @return HasMany
     */
    public function developments() : HasMany
    {
        return $this->hasMany(Development::class);
    }

    /**
     * Activity 모델에 대한 HasMany 인스턴스를 반환합니다.
     *
     * @return HasMany
     */
    public function activities() : HasMany
    {
        return $this->hasMany(Activity::class)->latest();
    }

    /**
     * 사용자가 마지막에 작성한 Comment에 대해 HasOne 인스턴스를 반환합니다.
     *
     * @return HasOne
     */
    public function lastComment() : HasOne
    {
        return $this->hasOne(Comment::class)->latest();
    }

    /**
     * 사용자가 관리자인지 확인합니다.
     *
     * @return bool
     */
    public function isAdmin() : bool
    {
        return in_array($this->email, config('auth.admin.email'));
    }

    /**
     * 사용자가 관리자인지 확인하는 Mutator 입니다.
     *
     * @return bool
     */
    public function getIsAdminAttribute() : bool
    {
        return $this->isAdmin();
    }

    /**
     * 사용자가 이메일 인증이 되었는지 확인 하는 Mutator 입니다.
     *
     * @return bool
     */
    public function getHasVerifiedEmailAttribute() : bool
    {
        return $this->hasVerifiedEmail();
    }

    /**
     * 아바타 경로를 반환하는 Mutator 입니다.
     *
     * @return string
     */
    public function getAvatarAttribute() : string
    {
        if ($this->avatar_path) {
            return Storage::url($this->avatar_path);
        }

        return asset('avatars/default.png');
    }

    /**
     * 비밀번호를 저장할 때 Hashing 하는 Mutator 입니다.
     *
     * @param  string|null  $password
     */
    public function setPasswordAttribute(string $password = null) : void
    {
        if ($password) {
            $this->attributes['password'] = Hash::make($password);
        }
    }

    /**
     * 소셜 사용자인지 확인하는 빌더를 반환합니다.
     *
     * @param Builder $query
     * @param string  $email
     * @return Builder
     */
    public function scopeSocialUser(Builder $query, string $email): Builder
    {
        return $query->where('email', $email)
            ->whereNull('password');
    }
}
