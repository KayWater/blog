<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use App\SocialiteUser;

class SocialiteController extends Controller
{
    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * redirect to socialite auth url
     * @param String $driver
     * @return void
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }
    
    /**
     * handle socialite callback
     * @param String $driver
     * @return void
     */
    public function handleCallback($driver)
    {
        $user = Socialite::driver($driver)->user();
        
        $attributes = [
            'socialite_id' => $user->id,
            'driver' => $driver,
        ];
        $values = [
            'socialite_id' => $user->id,
            'driver' => $driver,
            'nickname' => $user->nickname,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'token' => $user->token,
            'refresh_token' => $user->refreshToken,
            'expires_in' => $user->expiresIn,
        ];
        
        $socialiteUser = SocialiteUser::firstOrNew($attributes, $values);
        $socialiteUser->save();
      
        Auth::guard('socialite')->login($socialiteUser);
        
        return redirect("/");
    }
}