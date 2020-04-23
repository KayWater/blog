<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
use App\Models\Draft;
use App\Models\Tag;

class PostController extends Controller
{
    /**
     * Create a new controller instance
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Add a post
     * @param   \Illuminate\Http\Request
     * @return  Response
     */
    public function addPost(Request $request)
    {
        $user = Auth::guard('api')->user();

        $post = new Post();
        $post->user_id = $user->id;
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->status = Post::POST_STATUS_PUBLISHED;
        $post->published_at = now();

        $post->save();
        $tags = $request->input('tags');
        $post->tags()->attach(array_column($tags, 'id'));

        $draftID = $request->input('draftID');

        // if draft exist, delete it. 
        // avoid query database when draft id equal to 0.
        if($draftID && $draft = Draft::find($draftID)) {
            $draft->tags()->detach();
            $draft->delete();
        }

        return response()->json([
            'post' => $post->load('tags'),
        ]);
    }

    /**
     * Update a post
     * @param Illuminate\Http\Request $request
     * @param Integer $postID
     * @return Response
     */
    public function updatePost(Request $request, $postID)
    {
        $post = Post::findOrFail($postID);

        $this->authorize('update', $post);

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->save();
        // sync tags
        $tags = $request->input('tags');
        $post->tags()->sync(array_column($tags, 'id'));

        $draftID = $request->input('draftID');

        // if draft exist, delete it. 
        // avoid query database when draft id equal to 0.
        if($draftID && $draft = Draft::find($draftID)) {
            $draft->tags()->detach();
            $draft->delete();
        }

        return response()->json([
            'post' => $post->load('tags'),
        ]);
    }

    /**
     * Auto save post as draft
     * 
     * @param   \Illuminate\Http\Request
     * @return  Response
     */
    public function autosave(Request $request)
    {
        $user = Auth::guard('api')->user();

        $draftID = $request->input('draftID');
        $draft = Draft::findOrNew($draftID);

        $postID = $request->input('postID');
        if ($postID) {
            $draft = Draft::firstOrNew(['post_id' => $postID]);
        }

        $draft->user_id = $user->id;
        $draft->post_id = $postID;
        $draft->title = $request->input('title');
        $draft->content = $request->input('content');
        $draft->save();

        $tags = $request->input('tags');
        $draft->tags()->sync(array_column($tags, 'id'));

        return response()->json([
            'draft' => $draft->load('tags'),
        ]);

    }

    /**
     * Get post (pagination)
     * @param   \Illuminate\Http\Request
     * @return  Response
     */
    public function getPosts(Request $request)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);

        $total = Post::where('status', Post::POST_STATUS_PUBLISHED)->count();

        $posts = Post::with(['user:id,name', 'tags:tags.id,name'])
            ->where('status', Post::POST_STATUS_PUBLISHED)
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get();

        return response()->json([
            'posts' => $posts,
            'total' => $total,
        ]);
    }

    /**
     * Delete a post
     * 
     * @param   \Illuminate\Http\Request $request
     * @param   Integer $postID
     * @return  Response
     */
    public function deletePost(Request $request, $postID)
    {
        $post = Post::find($postID);

        // Whether the current user can delete the post
        $this->authorize('delete', $post);

        $post->tags()->detach();
        $post->forceDelete();

        return response()->json([
            'post' => $post,
        ]);
    }

    /**
     * Delete a draft
     * 
     * @param   \Illuminate\Http\Request $request
     * @param   Integer $draftID
     * @return  Response
     */
    public function deleteDraft(Request $request, $draftID)
    {
        $draft = Draft::find($draftID);
        
        // Whether the current user can delete the draft
        $this->authorize('delete', $draft);

        $draft->tags()->detach();
        $draft->delete();

        return response()->json([
            'draft' => $draft,
        ]);
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

        $total = Post::whereNotNull('published_at')
                        ->count();

        $articles = Post::with(['tags' => function($query){
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
        $article = Post::findOrFail($id);

        return response()->json([
            'post' => $article,
        ]);
    }
}