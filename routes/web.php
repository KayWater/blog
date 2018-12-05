<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');

Route::get('article', 'HomeController@index');
Route::get('tags', 'HomeController@tags');
Route::get('archive', 'HomeController@archive');


Route::get('article/{id}', 'ArticleController@show')->middleware("viewStatistics");
Route::get('article/tag/{id}', 'ArticleController@tag');

//admin route
Route::middleware(['auth','isAdmin'])->namespace('Admin')->group(function () {
   Route::get('/dashboard', 'HomeController@index')->name('dashboard');
   Route::get('/admin/user/local', 'Usercontroller@local');
   Route::get('/admin/user/socialite', 'Usercontroller@socialite');
   Route::get('/admin/tags', 'TagController@index');
   Route::post('/admin/tags', 'TagController@store');
   Route::post('/admin/tags/update', 'TagController@update');
   Route::get("/admin/article/edit/{id?}", "ArticleController@edit");
   Route::post('/admin/article/prestore', 'ArticleController@prestore');
   Route::post("/admin/article/store", 'ArticleController@store');
   Route::get("/admin/article/draft/{id}", 'ArticleController@draft');
   Route::get('/admin/article','ArticleController@index');
   Route::get('/admin/draft', 'DraftController@index');
   
   Route::post('/editor/upload', 'EditorController@upload');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//socialite auth
Route::get('auth/provider/{driver}', 'Auth\SocialiteController@redirectToProvider');
Route::get('auth/callback/{driver}', 'Auth\SocialiteController@handleCallback');

//statistics 
Route::get('statistics/userSource', 'StatisticsController@userSource');