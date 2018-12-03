<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\SocialiteUser;

class UserController extends Controller
{
    /**
     * create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * local user 
     * @param Request $request
     * @return void
     */
    public function local(Request $request)
    {
        $users = User::paginate(8);
        
        return view('admin.user.local', [
           'users' => $users, 
        ]);
    }
    
    /**
     * socialite user
     * @param Request $request
     * @return void
     */
    public function socialite(Request $request)
    {
        $users = SocialiteUser::paginate(8);
        
        return view('admin.user.socialite', [
            'users' => $users,
        ]);
    }
}