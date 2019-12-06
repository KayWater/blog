<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\facades\Auth;
use Laravel\Passport\Events\AccessTokenCreated;
use Laravel\Passport\Events\RefreshTokenCreated;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * login
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $params = [
    		'grant_type' => 'password',
    		'client_id' => config('passport.password_client_id'),
    		'client_secret' => config('passport.password_client_secret'),
    		'username' => $request->input('email'),
    		'password' => $request->input('password'),
    		'scope' => '*'
        ];
        
    	$request->request->add($params);

    	$proxy = Request::create('oauth/token', 'POST');

    	return Route::dispatch($proxy);
    }

    /**
     * Logout
     * 
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    // public function logout(Request $request) 
    // {
    //     if (Auth::guard('api')->check()) {
    //         Auth::guard('api')->user()->token()->revoke();
    //     }

    //     return response()->json([
    //         'message' => '注销成功',
    //     ], 200);
    // }
}
