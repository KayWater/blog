<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Article;
use App\Tag;
use DB;
use App\Events\ArticleView;

class ArticleController extends Controller
{
    /**
     * create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * show article
     * @param Request $request
     * @param Integer $id
     * @return void
     */
    public function show(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        //event(new ArticleView($article));
        return view("article", [
            'article' => $article,
        ]);
    }
    
    /**
     * show artilces with specified tag
     * @param Request $request
     * @param Integer $id
     * @return void
     */
    public function tag(Request $request, $id)
    {
        $articles = null;
        Tag::with(['articles' => function($query) use(&$articles){
            $articles = $query->with('tags')->paginate(6);
        }])->find($id);
        
        return view("index", [
            'articles' => $articles,
        ]);
    }
}