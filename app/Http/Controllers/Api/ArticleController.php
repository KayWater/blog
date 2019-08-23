<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Article;
use App\Tag;

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
     * index method
     * @param Request $request
     * @return 
     */
    public function index(Request $request)
    {
        $pageSize = (Int)$request->input('pageSize', 10);
        $offset = (Int)$request->input('offset', 0);

        $total = Article::whereNotNull('published_at')
                        ->count();

        $articles = Article::with(['tags' => function($query){
                                $query->where('status', 1);
                            }])
                            ->orderBy('published_at', 'desc')
                            ->offset($offset)
                            ->limit($pageSize)
                            ->get();

        // archive 
        // $years = Article::select(DB::raw('date_format(published_at, "%Y") as year'),
        //     DB::raw('count(*) as total'))->groupBy('year')->orderBy('year', 'desc')->get();
        // $tags = Tag::all();
        
        return response()->json([
            'articles' => $articles,
            'total' => $total,
            'pageSize' => $pageSize,
        ]);
    }

    /**
     * show post
     * @param Request $request
     * @param Int $id
     * @return json
     */
    public function show(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        return response()->json([
            'post' => $article,
        ]);
    }
}