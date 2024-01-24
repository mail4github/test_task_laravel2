<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;

/**
 * Class LoginService
 *
 * @package App\Services\Auth
 */
class LoginService
{
    /**
     * Attempt user login and generate an access token.
     *
     * @param array $credentials User login credentials (email and password).
     *
     * @return string Access token on successful login.
     * @throws \Exception If login fails.
     */
    public function attemptLogin(array $credentials)
    {
		try {
			if (Auth::attempt($credentials)) {
                $user = Auth::user();
				return $user->createToken('API Token')->accessToken;
            }
			throw new \Exception('Unauthorized');
        } catch (\Exception $e) {
            // Log or handle the exception as needed.
            throw $e;
        }
    }

    /**
     * Logout the authenticated user and revoke the access token.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     *
     * @return void
     */
    public function logout($request)
    {
        try {
            $request->user()->token()->revoke();
        } catch (\Exception $e) {
            // Log or handle the exception as needed.
            throw $e;
        }
    }
}
