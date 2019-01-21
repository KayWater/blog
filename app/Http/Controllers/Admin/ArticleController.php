<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;
use App\Article;
use App\Draft;
use Validator;

class ArticleController extends Controller
{
    /**
     * create a new controler instance
     * return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * article list
     * @param Request $request
     * @return void
     */
    public function index()
    {
        $articles = Article::with('tags')->paginate(8);
        return view("admin.article.index", [
            'articles' => $articles,
        ]);
    }
    
    /**
     * article edit 
     * @param Request $request
     * @param Integer $id
     * @return void
     */
    public function edit(Request $request, $id=null)
    {
        $tags = Tag::all();
        $drafts = Draft::all();
        
        if($id == null) {
            return view("admin.article.edit", [
                'tags' => $tags,
                'drafts' => $drafts,
            ]);
        }
        $article = Article::with('tags:tags.id')->findOrFail($id);
        return view("admin.article.edit", [
            'tags' => $tags,
            'drafts' => $drafts,
            'article' => $article,
        ]);
    }
    

    
    /**
     * store as published article
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //validator config
        $rules = [
            'title' => "required|string|between:1,24",
            'content' => "required",
            'draftId' => "integer",
            'tags' => "required|between:1,3",
            'tags.*' => "integer",
        ];
        $messages = [
            'title.required' => "标题不能为空",
            'title.string' => "标题必须为字符串",
            'title.between' => "标题为1~24位字符",
            'content.required' => "内容不能为空",
            'draftId.integer' => "未知错误",
            'tags.required' => "必须选择1~3个标签",
            'tags.between' => "只能选择1~3个标签",
            'tags.*.integer' => "错误的标签",
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        //something invalid
        if($validator->fails()) 
        {
            $errors = $validator->errors();
            return response()->json([
                'errorCode' => 1,
                'errorMsg' => $errors
            ]);
        }
        $draft_id = $request->input('draftId');
        $article = Article::firstOrNew(['draft_id' => $draft_id]);
        $id = $request->input("id");
        $article->title = $request->input("title");
        $article->content = $request->input("content");
        $article->draft_id = $request->input("draftId");
        $article->published_at = $article->published_at ? $article->published_at : date("Y-m-d H:i:s");
        $result = $article->save();
        
        $article->tags()->sync($request->input("tags"));
        
        if($result === true)
        {
            Draft::destroy($article->draft_id);
            return response()->json([
                'errorCode' => 0,
                'errorMsg' => "OK",
                'data' => [
                    'articleId' => $article->id,
                ],
            ]);
        }
        else 
        {
            return response()->json([
                'errorCode' => 1,
                'errorMsg' => "服务器内部错误",
            ]);
        }
    }
}