<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance
     * 
     */
    public function __construct()
    {
        
    }

    /**
     * Get current user
     * 
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function me(Request $request)
    {
        $user = Auth::guard('api')->user();

        return response()->json([
            'user' => $user,
        ]);
    }

    
}