<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * 대량 할당할 수 있는 특성.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
     * 주어진 data로 User 레코드를 저장하고 반환합니다.
     *
     * @param  array  $data
     * @return static
     */
    public static function register(array $data) : User
    {
        return static::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => isset($data['password']) && $data['password'] ? Hash::make($data['password']) : null,
        ]);
    }

    /**
     * 사용자가 관리자인지 확인합니다.
     *
     * @return bool
     */
    public function isAdmin() : bool
    {
        return in_array($this->email, config('auth.admin'));
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
}
