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

<<<<<<< HEAD
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    /*
     |---------------------------------------------------
     | Get All Cafes
     |---------------------------------------------------
     | URL:             /api/v1/cafes
     | Controller:      API\CafesController@getCafes
     | Method:          GET
     | Description :    Gets all of the cafes in the application
     |
     */
    Route::get('/cafes', 'API\CafesController@getCafes');

    /*
     |-------------------------------------------------------------------------------
     | Get An Individual Cafe
     |-------------------------------------------------------------------------------
     | URL:            /api/v1/cafes/{id}
     | Controller:     API\CafesController@getCafe
     | Method:         GET
     | Description:    Gets an individual cafe
    */
    Route::get('/cafes/{id}', 'API\CafesController@getCafe');

     /*
     |-------------------------------------------------------------------------------
     | Adds a New Cafe
     |-------------------------------------------------------------------------------
     | URL:            /api/v1/cafes
     | Controller:     API\CafesController@postNewCafe
     | Method:         POST
     | Description:    Adds a new cafe to the application
    */
    Route::post('/cafes', 'API\CafesController@postNewCafe');

    /*
     |------------------------------------------------------------------------------
     | Get all brew method
     |------------------------------------------------------------------------------
     | URL:             /api/v1/brew-methods
     | Controller       API\BrewMethodsController@getBrewMethods
     | Method:          GET
     | Description:     Get all brew method in the application 
     */
    Route::get('/brew-methods', 'API\BrewMethodsController@getBrewMethods');
});
=======
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/articles', 'Api\ArticleController@index');
Route::get('/article/{id}', 'Api\ArticleController@show');
>>>>>>> c22dcc9574e65921368db93827849f82cef848db
