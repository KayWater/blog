<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Article;
use App\Tag;

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
        // $articles = Article::with(['tags' => function($query){
        //     $query->where('status', 1);
        // }])->orderBy('published_at', 'desc')->paginate(8);
        // // archive 
        // $years = Article::select(DB::raw('date_format(published_at, "%Y") as year'),
        //     DB::raw('count(*) as total'))->groupBy('year')->orderBy('year', 'desc')->get();
        // $tags = Tag::all();
        
        // return view("index", [
        //     'articles' => $articles,
        //     'tags' => $tags,
        //     'years' => $years,
        // ]);

        return view('app');
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
     * @param String $year
     * @return 
     */
    public function archive(Request $request, $year=null)
    {
        #DB::enableQueryLog();
//         $years = Article::select('published_at')->get()->groupBy(function ($item, $key) {
//             return $item->published_at->format("Y");
//         })->map(function ($item, $key) {
//             return $item[$key] = count($item);
//         });
        # 文章按年分组统计
        $years = Article::select(DB::raw('date_format(published_at, "%Y") as year'), 
            DB::raw('count(*) as total'))->groupBy('year')->orderBy('year', 'desc')->get();
        #dd(DB::getQueryLog());
        if($year==null) {
            $articles = Article::with(["tags" => function($query) {
                $query->where('status', 1);
            }])->orderBy('published_at', 'desc')->paginate(8);
        } else {
            $articles = Article::with(["tags" => function($query) {
                $query->where('status', 1);
            }])->where(Db::raw('date_format(published_at, "%Y")'), $year)
            ->orderBy('published_at', 'desc')->paginate(8);
        }
        
        $tags = Tag::all();
        return view('archive', [
            'years' => $years,
            'articles' => $articles,
            'tags' => $tags,
        ]);
    }
}
