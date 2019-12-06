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


});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function() {
    /**
     * Get current user
     * URL:             /api/v1/me
     * Controller:      Api\UserController@me
     * Method:          GET
     * Description:     get current user
     */
    Route::get('/me', 'Api\UserController@me');
    
});
