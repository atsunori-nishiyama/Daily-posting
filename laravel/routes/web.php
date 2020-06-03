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

//それまでに定義した内容(prefix('articles')とname('articles.'))が、groupメソッドにクロージャ(無名関数)として渡した各ルーティングにまとめて適用
Route::prefix('articles')->name('articles.')->group(function (){
  Route::put('/{article}/like', 'ArticleController@like')->name('like')->middleware('auth');
  Route::delete('/{article}/like', 'ArticleController@unlike')->name('unlike')->middleware('auth');
});

Route::get('/tags/{name}', 'TagController@show')->name('tags.show');

Route::prefix('users')->name('users.')->group(function (){
  Route::get('/{name}', 'UserController@show')->name('show');
  Route::get('/{name}/likes', 'UserController@likes')->name('likes');

  Route::middleware('auth')->group(function (){
    Route::put('/{name}/follow', 'UserController@follow')->name('follow');
    Route::delete('/{name}/follow', 'UserController@unfollow')->name('unfollow');
  });
});