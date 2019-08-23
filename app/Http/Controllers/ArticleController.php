<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Article;
use App\Tag;
use App\Events\ArticleView;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance
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
        
        $years = Article::select(
            DB::raw('date_format(published_at, "%Y") as year'),
            DB::raw('count(*) as total')
            )->groupBy('year')->orderBy('year', 'desc')->get();
        $tags = Tag::all();
            
        return view("index", [
            'articles' => $articles,
            'years' => $years,
            'tags' => $tags,
        ]);
    }
    /**
     * search articles
     * @param Request $request
     * @param String $search
     * @return void
     */
    public function search(Request $request, $search="")
    {
        $search = $request->input('search');
        $articles = Article::search($search)->paginate(8);
        return view("index", [
            'articles' => $articles,
        ]);
    }
}