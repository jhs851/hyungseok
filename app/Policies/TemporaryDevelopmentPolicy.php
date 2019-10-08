<?php

namespace App\Policies;

use App\Models\{User, TemporaryDevelopment};
use Illuminate\Auth\Access\HandlesAuthorization;

class TemporaryDevelopmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the temporary development.
     *
     * @param User                 $user
     * @param TemporaryDevelopment $temporaryDevelopment
     * @return mixed
     */
    public function update(User $user, TemporaryDevelopment $temporaryDevelopment)
    {
        return $user->id == $temporaryDevelopment->user_id;
    }
}
