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

// Route::get('/', function () {
//     return view('welcome');
// });

// use Illuminate\Routing\Route;

// use Illuminate\Support\Facades\Auth;

// use Illuminate\Routing\Route;

Auth::routes();
Route::get('/', 'ArticleController@index')->name('articles.index');
Route::resource('/articles', 'ArticleController')->except(['index', 'show'])->middleware('auth');
//'auth':リクエストをコントローラーで処理する前にユーザーがログイン済みであるかどうかをチェック

Route::resource('/articles', 'ArticleController')->only(['show']);