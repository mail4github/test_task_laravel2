<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Services\Auth\LoginService;

/**
 * Class LoginController
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * The redirect path after a successful login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * The login service instance.
     *
     * @var LoginService
     */
    private $loginService;

    /**
     * Create a new LoginController instance.
     *
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->middleware('guest')->except('logout');
        $this->loginService = $loginService;
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param Request $request The HTTP request instance.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $token = $this->loginService->attemptLogin($request->only('email', 'password'));

            return response()->json(['token' => $token], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request The HTTP request instance.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->loginService->logout($request);

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}

/*
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token')->accessToken;

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }
}
*/