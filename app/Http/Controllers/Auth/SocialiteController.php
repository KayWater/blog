<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use App\Article;

class SocialiteController extends Controller
{
    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }
    
    public function weibo()
    {
        return Socialite::with('weibo')->redirect();    
    }
    
    public function callback()
    {
        $oauthUser = Socialite::with('weibo')->user();
        

        Auth::login($oauthUser);
        return view("welcome");
//         dd($oauthUser);
//         var_dump($oauthUser->getId());
//         var_dump($oauthUser->getNickname());
//         var_dump($oauthUser->getName());
//         var_dump($oauthUser->getEmail());
//         var_dump($oauthUser->getAvatar());
    }
   
}