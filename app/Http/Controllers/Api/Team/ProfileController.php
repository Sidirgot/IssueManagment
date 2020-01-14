<?php

namespace App\Http\Controllers\Api\Team;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersProfileRequest;
use App\User;

class ProfileController extends Controller
{
    /**
     * Update Users Profile Inforamtion.
     *
     * @param UsersProfileRequest $request
     * @param User $user
     */
    public function update(UsersProfileRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->update($request->validated());

        return response()->json('Profile Updated', 200);
    }
}
