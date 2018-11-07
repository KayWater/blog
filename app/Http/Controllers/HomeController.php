<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Tag;

use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

     /**
     * index method
     * @param Request $request
     * @return 
     */
    public function index(Request $request)
    {
        //$articles = Article::with('tags')->paginate(8);
        $articles = Article::with(['tags' => function($query){
            $query->where('status', 1);
        }])->paginate(8);
        return view("index", [
            'articles' => $articles,
        ]);
    }
    
    /**
     * all tags
     * @param Request $request
     * @return 
     */
    public function tags(Request $request)
    {
        $tags = Tag::where('status', 1)->get();
        return view("tags", [
            "tags" => $tags,
        ]);
    }
    
    /**
     * article archive
     * @param Request $request
     * @return 
     */
    public function archive(Request $request)
    {
        //DB::enableQueryLog();
        $years = Article::select('published_at')->get()->map(function($item, $key) {
            return $item->published_at->format("Y");
        })->unique();
        //dd(DB::getQueryLog());
        $articles = Article::with(["tags" => function($query) {
            $query->where('status', 1);
        }])->paginate(8);
        
        return view('archive', [
            'years' => $years,
            'articles' => $articles,
        ]);
    }
}
