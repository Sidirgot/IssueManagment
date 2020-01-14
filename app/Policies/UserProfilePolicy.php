<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Detemine if the current users id is the authenticated user.
     *
     * @param User $user
     * @return void
     */
    public function update(User $user)
    {
        return $user->isTheCurrentAuthenticatedUser();
    }
}
