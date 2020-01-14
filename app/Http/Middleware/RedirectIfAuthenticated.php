<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {

            return redirect($this->handleRedirects());
        }

        return $next($request);
    }

    /**
     * Handle authenticated redirects based on the user role.
     *
     * @return string
     */
    protected function handleRedirects()
    {
        if (auth()->user()->isManager()) {
            return '/manage/dashboard';
        }
        else if (auth()->user()->isTester()) {
            return '/testers/dashboard';
        }
    }
}
