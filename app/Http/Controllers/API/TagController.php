<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tag;

class TagController extends Controller 
{
    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        
    }

    /**
     * Get tags (pagination)
     * @param   \Illuminate\Http\Request
     * @return  Response
     */
    public function getTags(Request $request)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        $total = Tag::count();

        $tags = Tag::limit($limit)->offset($offset)->get();

        // next url
        if ($limit + $offset >= $total) {
            $next = "";
        } else {
            $next = url()->current() . '?limit=' . $limit . '&offset=' . ($offset + $limit);
        }

        return response()->json([
            'tags' => $tags,
            'total' => $total,
            'next' => $next,
            'offset' => $offset,
        ]);
    }

    /**
     * Add a new tag
     * @param Illuminate\Http\Request $request
     * @return Response
     */
    public function addTag(Request $request) 
    {
        $name = $request->input('name');
        $tag = Tag::Where('name', '=', $name)->first();

        if ($tag) {
            return response()->json([
                'name' => ['This tag is exist'],
            ], 400);
        }

        $tag = new Tag();
        $tag->name = $name;
        $tag->status = Tag::STATUS_AVAILABLE;
        $tag->save();
        return response()->json([
            'tag' => $tag,
        ]);
    }
}