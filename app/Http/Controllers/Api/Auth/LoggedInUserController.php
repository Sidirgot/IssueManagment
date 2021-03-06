<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

class LoggedInUserController extends Controller
{
    /**
     * Return the authenticated users information.
     *
     * @return void
     */
    public function user()
    {
        return auth()->user();
    }
}