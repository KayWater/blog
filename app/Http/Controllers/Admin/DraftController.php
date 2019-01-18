<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Draft;
use App\Tag;

class DraftController extends Controller
{
    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * Show drafts
     * @param Request $request
     * @return 
     */
    public function index(Request $request)
    {
        $drafts = Draft::paginate(8);
        return view("admin.article.drafts", [
            'drafts' => $drafts,
        ]);
    }
    
}