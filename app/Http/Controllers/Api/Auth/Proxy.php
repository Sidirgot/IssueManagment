<?php

namespace App\Http\Controllers\Api\Auth;

use App\User;

class Proxy
{
    /**
     * Attemp to login the user.
     *
     * @param array $credentials
     */
    public function attemptLogin(array $credentials)
    {
        $user = User::findUserByEmail($credentials['username']);

        if (is_null($user)) {
            throw new \Exception('No user found with the provided email.', 401);
        }

        return $this->proxy('password', $credentials);
    }

    /**
     * Return a json response after a successfull login.
     *
     * @param array $response
     * @return void
     */
    public function jsonResponse(array $response)
    {
        $data = [
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in']
        ];

        return response()->json($data, 200);
    }

    /**
     * Revoke the users tokens from the database.
     *
     */
    public function revokeTokens()
    {
        auth()->user()->tokens->each(function($token) {
            $token->delete();
        });
    }

    /**
     * Handle the oauth authentication from the passport oauth server.
     *
     * @param string $grandType
     * @param array $credentials
     */
    protected function proxy(string $grandType, array $credentials = [])
    {
        $oathApiFormData = [
            'form_params' => [
                'grant_type' => $grandType,
                'client_id' => env('PASSWORD_CLIENT_ID'),
                'client_secret' => env('PASSWORD_CLIENT_SECRET'),
                'username' => $credentials['username'],
                'password' => $credentials['password'],
                'scope' => '',
            ],
        ];

        $client = new \GuzzleHttp\Client();

        $response = $client->post('http://app.test/oauth/token', $oathApiFormData);

        if ($response->getStatusCode() != 200){
            throw new \Exception('There was a server related issue.', 400);
        }

        return json_decode((string) $response->getBody(), true);
    }
}
