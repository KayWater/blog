<?php 
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * 
     */
    public function  index()
    {

        
        return view('admin.index');
    }
}