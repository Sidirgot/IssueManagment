<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    private $proxy;

    /**
     * Create a new Proxy instance.
     *
     * @param Proxy $proxy
     */
    public function __construct(Proxy $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * Handle the login process.
     *
     * @param LoginRequest $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        return $this->proxy->jsonResponse(
                    $this->proxy->attemptLogin($request->validated())
                );
    }

    /**
     * Handle the logout process.
     *
     * @return void
     */
    public function logout()
    {
        $this->proxy->revokeTokens();

        return response()->json('Logged Out Successfully', 200);
    }
}