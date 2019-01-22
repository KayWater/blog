<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\SocialiteUser;

use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * statistics user source
     * @param Request $request
     * @return JSON
     */
    public function userSource()
    {
        //local user
        $localUserInfo = User::select('is_admin', DB::raw('count(*) as total'))
                    ->groupBy('is_admin')
                    ->get();
        $localUserInfo = $localUserInfo->mapWithKeys(function ($item) {
            $userType = $item['is_admin'] == 1 ? 'administrator' : 'general';
            return [[$userType, $item['total'] ]];
        });
        //socialite user without binded
        $socialiteUserInfo = SocialiteUser::select('driver', DB::raw('count(*) as total'))
                        ->whereNull('user_id')
                        ->groupBy('driver')
                        ->get();
        $socialiteUserInfo = $socialiteUserInfo->mapWithKeys(function ($item) {
           return [[$item['driver'], $item['total']]]; 
        });
        $userInfo = $localUserInfo->concat($socialiteUserInfo);
 
        return response()->json([
            'errorCode' => 1,
            'errorMsg' => 'OK',
            'data' => $userInfo,
        ]);
    }
    
}