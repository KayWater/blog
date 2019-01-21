<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Draft;
use App\Tag;
use App\Article;

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
    
    /**
     * draft edit
     * @param Request $request
     * @param Integer $id
     * @return void
     */
    public function edit(Request $request, $id = null)
    {
        $tags = Tag::all();
        $drafts = Draft::all();
        
        $draft = Draft::findOrFail($id);
        $article = Article::with('tags:tags.id')->findOrFail($id);
        $draft->tags = $article->tags;
        return view("admin.article.edit", [
            'tags' => $tags,
            'drafts' => $drafts,
            'draft' => $draft,
        ]);
    }
    
    /**
     * save as draft
     * @param Request $request
     * @return void
     */
    public function prestore(Request $request)
    {
        //validator settings
        $rules = [
            'id' => "required|integer",
            "title" => "nullable|string|between:1, 24",
        ];
        $messages = [
            'id.required' => "错误请求",
            'id.integer' => "错误请求",
            'title.string' => "标题必须为字符串",
            'title.between' => "标题为1~24位字符",
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        //something wrong in validator
        if($validator->fails())
        {
            $errors = $validator->errors();
            return response()->json([
                'errorCode' => 1,
                'errorMsg' => $errors
            ]);
        }
        
        $id = $request->input("id");
        $draft = Draft::withTrashed()->findOrNew($id);
        $draft->title = $request->input('title');
        $draft->content = $request->input('content');
        $draft->deleted_at = null;
        $result = $draft->save();
        if($result === true)
        {
            return response()->json([
                'errorCode' => 0,
                'errorMsg' => "OK",
                'data' => [
                    'draftId' => $draft->id,
                    'updatedAt' => $draft->updated_at->format("Y-m-d H:i:s"),
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