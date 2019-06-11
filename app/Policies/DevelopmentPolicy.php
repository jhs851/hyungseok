<?php

namespace App\Policies;

use App\Models\{User, Development};
use Illuminate\Auth\Access\HandlesAuthorization;

class DevelopmentPolicy
{
    use HandlesAuthorization;

    /**
     * 사용자가 Development을 업데이트할 수 있는지 확인합니다.
     *
     * @param  User  $user
     * @param  Development  $development
     * @return bool
     */
    public function update(User $user, Development $development) : bool
    {
        return $user->id == $development->user_id;
    }
}
