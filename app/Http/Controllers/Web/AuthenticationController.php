<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

use App\SocialiteUser;

class AuthenticationController extends Controller
{
    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Redirect to socialite auth url
     * @param String $driver
     * @return void
     */
    // public function redirectToProvider($driver)
    // {
    //     return Socialite::driver($driver)->redirect();
    // }
    public function getSocialRedirect($driver)
    {
        try {
            return Socialite::driver($driver)->redirect();
        } catch (\InvalidArgumentException $e) {
            return redirect('/login');
        }
    }

    /**
     * Handle socialite callback
     * @param String $driver
     * @return void
     */
    // public function handleCallback($driver)
    // {
    //     $user = Socialite::driver($driver)->user();
        
    //     $attributes = [
    //         'socialite_id' => $user->id,
    //         'driver' => $driver,
    //     ];
    //     $values = [
    //         'socialite_id' => $user->id,
    //         'driver' => $driver,
    //         'nickname' => $user->nickname,
    //         'name' => $user->name,
    //         'email' => $user->email,
    //         'avatar' => $user->avatar,
    //         'token' => $user->token,
    //         'refresh_token' => $user->refreshToken,
    //         'expires_in' => $user->expiresIn,
    //     ];
    //     //find the socialite user, create it when not found
    //     $socialiteUser = SocialiteUser::firstOrNew($attributes, $values);
    //     $socialiteUser->save();
      
    //     Auth::guard('socialite')->login($socialiteUser);

    //     return redirect("/");
    // }
     /**
     * handle socialite callback
     * @param String $driver
     * @return void
     */
    public function getSocialCallback($driver)
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
        //find the socialite user, create it when not found
        $socialiteUser = SocialiteUser::firstOrNew($attributes, $values);
        $socialiteUser->save();
      
        Auth::guard('socialite')->login($socialiteUser);

        return redirect('/#/home');
    }
}