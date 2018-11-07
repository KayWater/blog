<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * img upload 
     * @param Request $request
     * @return
     */
    public function upload(Request $request)
    {
        $path = $request->file("upload")->store('editor/upload', 'public');
        
        return response()->json([
            'uploaded' => 1,
            'url' => asset("storage/$path"),
        ]);
    }
}