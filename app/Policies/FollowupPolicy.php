<?php

namespace App\Policies;

use App\Followup;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FollowupPolicy
{
    use HandlesAuthorization;

   public function owner(User $user, Followup $followup)
   {
       return $user->canAccessFollowup($followup);
   }
}
