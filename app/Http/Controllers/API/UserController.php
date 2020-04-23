<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Post;
use App\Models\Draft;

class UserController extends Controller
{
    /**
     * Create a new controller instance
     * 
     */
    public function __construct()
    {
        
    }

    /**
     * Get current user
     * 
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function me(Request $request)
    {
        $user = Auth::guard('api')->user();

        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Get the post belongs to current user.
     * 
     * @param   \Illuminate\Http\Request
     * @param   Integer $postID
     * @return  Response
     */
    public function getPost(Request $request, $postID)
    {
        $user = Auth::guard('api')->user();

        $post = Post::with('tags')->where([
            ['user_id', '=', $user->id],
        ])->findOrFail($postID);

        return response()->json([
            'post' => $post,
        ]);
    }

    /**
     * Get posts belong to current user (pagination).
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  Response
     */
    public function getPosts(Request $request)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);
        
        $user = Auth::guard('api')->user();

        $total = Post::where('user_id', $user->id)
                        ->count();

        $posts = Post::with('tags')
                    ->where('user_id', $user->id)
                    ->orderBy('updated_at', 'desc')
                    ->limit($limit)
                    ->offset($offset)
                    ->get();

        return response()->json([
            'posts' => $posts,
            'total' => $total,
        ]);
    }

    /**
     * Get drafts belong to current user (pagination).
     * 
     * @param   \Illuminate\Http\Request $request
     * @return  Response
     */
    public function getDrafts(Request $request)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);
        
        $user = Auth::guard('api')->user();

        $total = Draft::where('user_id', $user->id)
                        ->count();

        $drafts = Draft::where('user_id', $user->id)
                    ->orderBy('updated_at', 'desc')
                    ->limit($limit)
                    ->offset($offset)
                    ->get();

        return response()->json([
            'drafts' => $drafts,
            'total' => $total,
        ]);
    }

    /**
     * Get the draft belongs to current user.
     * 
     * @param   \Illuminate\Http\Request
     * @param   Integer $draftID
     * @return  Response
     */
    public function getDraft(Request $request, $draftID)
    {
        $user = Auth::guard('api')->user();

        $draft = Draft::with('tags')->where([
            ['user_id', '=', $user->id],
        ])->findOrFail($draftID);

        return response()->json([
            'draft' => $draft,
        ]);
    }
}