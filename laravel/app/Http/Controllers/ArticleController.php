<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function index()
    {
        $articles = Article::all()->sortByDesc('created_at'); //降順で並び替え（コレクション）


        return view('articles.index', ['articles' => $articles]);
        //'articles'というキーを定義することで、ビューファイル側で$articlesという変数が使用可
        //下記同じ結果の書き方
        // return view('article.index')->with(['articles' => $articles]);
        // return view('articles.index', compact('articles'));

    }

    public function create()
    {
        return view('articles.create');
    }

    //引数$requestはArticleRequestクラスのインスタンスである、ということを宣言
    //storeメソッドの第一引数に、ArticleRequestクラスのインスタンス以外のものが渡されるとTypeErrorという例外が発生して処理は中断
    //メソッドの引数で型宣言を行うと、そのクラスのインスタンスが自動で生成されてメソッド内で使える
    //DI: 外で生成されたクラスのインスタンスをメソッドの引数として受け取る $article = new Article();と記述が同じ意味
    public function store(ArticleRequest $request, Article $article)
    {
        //記事登録画面から送信されたPOSTリクエストのボディ部のタイトル(title)と本文(body)の値をそれぞれ代入
        // $article->title = $request->title;
        // $article->body = $request->body;

        //Artcleモデルのfillableプロパティ内に指定しておいたプロパティ(ここではtitleとbody)のみが、$articleの各プロパティに代入
        $article->fill($request->all());
        //userメソッドを使うことでUserクラスのインスタンスにアクセス
        //そこからユーザーのidを取得し、これもArticleモデルのインスタンスのuser_idプロパティに代入
        $article->user_id = $request->user()->id;
        //articlesテーブルにレコードが新規登録
        $article->save();
        return redirect()->route('articles.index');
    }
}
