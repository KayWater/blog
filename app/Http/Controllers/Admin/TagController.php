<?php
namespace App\Http\Controllers\Admin;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;


class TagController extends Controller
{
    /**
     * create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }
    
    /**
     * show tag list
     */
    public function index()
    {
        $tags = Tag::withCount('articles')->paginate(8);
        
        return view("admin.tag.index", ['tags' => $tags]);
    }
    
    /**
     * store tags
     * @param Request $request
     * @return 
     */
    public function store(Request $request)
    {
        $id = intval($request->input("id", 0));
        $tagName = $request->input("tagName");
        $status = $request->input("status", 1) == 0 ? 0 : 1;
        
        //Validator config
        $rules = [
            'tagName' => "required|string|between:2,18",
        ];
        $messages = [
            'tagName.required' => "标签名称不能为空",
            'tagName.string' => "标签名称只能为字符串",
            'tagName.between' => "标签名称只能包含2~18位字符",
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        
        if($validator->fails())
        {
            $errors = $validator->errors();
            return response()->json([
                'errorCode' => 1,
                'errorMsg' => $errors,
            ]);
        }

        $tag = Tag::findOrNew($id);
        $tag->name = $tagName;
        $tag->status = $status;
        $result = $tag->save();
        if($result === true) 
        {
            return response()->json([
                'errorCode' => 0,
                'errorMsg' => "OK",
                'data' => [
                    "tagId" => $tag->id,
                ],
            ]);
        }
    }
    
    /**
     * update tag
     * @param Request $request
     * @return
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input("status") == 0 ? 0 : 1;
        
        $tag = Tag::find($id);
        $tag->status = $status;
        $result = $tag->save();
        if($result !== true) 
        {
            return response()->json([
                'errorCode' => 1,
                'errorMsg' => "更新失败"
            ]);
        }
    }
}

