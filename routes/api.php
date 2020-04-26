<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {
    /**
     * User regist
     * URL:             /api/v1/auth/register
     * Controller:      Api\Auth\RegisterController@register
     * Method:          POST
     * Description:     user regist
     */
    Route::post('/auth/register', 'Api\Auth\RegisterController@register');

    /**
     * User login
     * URL:             /api/v1/auth/login
     * Controller:      Api\Auth\LoginController@login
     * Method:          POST
     * Description:     user login
     */
    Route::post('/auth/login', 'Api\Auth\LoginController@login');

    /**
     * Get tags (pagination)
     * URL:             /api/v1/tags
     * Controller:      Api\TagController@getTags
     * Method:          GET
     * Description:     get tags
     */
    Route::get('/tags', 'Api\TagController@getTags');

    /**
     * Get posts (pagination)
     * URL:             /api/v1/posts
     * Controller:      Api\PostController@getPosts
     * Method:          GET
     * Description:     Get posts
     */
    Route::get('/posts', 'Api\PostController@getPosts');

    /**
     * Get post
     * URL:             /api/v1/post/{id}
     * Controller:      Api\PostController@getPost
     * Method:          GET
     * Description:     Get Post
     */
    Route::get('/post/{id}', 'Api\PostController@getPost');

});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {
    /**
     * Logout
     * URL:             /api/v1/auth/logout
     * Controller:      Api\Auth\LoginController@logout
     * Method:          POST
     * Description:     Logout
     */
    Route::post('/auth/logout', 'Api\Auth\LoginController@logout');

    /**
     * Get current user
     * URL:             /api/v1/me
     * Controller:      Api\UserController@me
     * Method:          GET
     * Description:     get current user
     */
    Route::get('/me', 'Api\UserController@me');
    
    /**
     * Add a new tag
     * URL:             /api/v1/tag
     * Controller:      Api\TagController@addTag
     * Method:          POST
     * Description:     Add a new tag
     */
    Route::post('/tag', 'Api\TagController@addTag');

    /**
     * Auto save post as draft
     * URL:             /api/v1/post/autosave
     * Controller:      Api\PostController@autosave
     * Method:          POST
     * Description:     Auto save post as draft
     */
    Route::post('/post/autosave', 'Api\PostController@autosave');

    /**
     * Add a new post
     * URL:             /api/v1/post
     * Controller:      Api\PostController@addPost
     * Method:          POST
     * Description:     Add a new post
     */
    Route::post('/post', 'Api\PostController@addPost');

    /**
     * Update a post
     * URL:             /api/v1/post/{postID}
     * Controller:      Api\PostController@updatePost
     * Method:          POST
     * Description:     Update a new post
     */
    Route::put('/post/{postID}', 'Api\PostController@updatePost');

    /**
     * Delete a post
     * URL:             /api/v1/post/{postID}
     * Controller:      Api\PostController@deletePost
     * Method:          DELETE
     * Description:     Delete a post
     */
    Route::delete('/post/{postID}', 'Api\PostController@deletePost');

    /**
     * Delete a draft
     * URL:             /api/v1/draft/{draftID}
     * Controller:      Api\PostController@deleteDraft
     * Method:          DELETE
     * Description:     Delete a draft
     */
    Route::delete('/draft/{draftID}', 'Api\PostController@deleteDraft');

    /**
     * Get posts belongs to current user (paginatin).
     * URL:             /api/v1/user/posts
     * Controller:      Api\UserController@getPosts
     * Method:          GET
     * Description:     Get posts belongs to current user.
     */
    Route::get('/user/posts', 'Api\UserController@getPosts');

    /**
     * Get the post belongs to current user.
     * URL:             /api/v1/user/post/{postID}
     * Controller:      Api\UserController@getPost
     * Method:          GET
     * Description:     Get the post belongs to current user.
     */
    Route::get('/user/post/{postID}', 'Api\UserController@getPost');

    /**
     * Get the drafts belong to current user (pagination).
     * URL:             /api/v1/user/drafts
     * Controller:      Api\UserController@getDrafts
     * Method:          GET
     * Description:     Get drafts belongs to current user.
     */
    Route::get('/user/drafts', 'Api\UserController@getDrafts');

    /**
     * Get the draft belongs to current user.
     * URL:             /api/v1/user/drafts
     * Controller:      Api\UserController@getDraft
     * Method:          GET
     * Description:     Get draft belongs to current user.
     */
    Route::get('/user/draft/{draftID}', 'Api\UserController@getDraft');

});
