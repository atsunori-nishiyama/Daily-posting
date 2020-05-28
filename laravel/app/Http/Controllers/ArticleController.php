<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function __construct() //クラスのインスタンスが生成された時に初期処理
    {
        $this->authorizeResource(Article::class, 'article');
    }
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

        $request->tags->each(function ($tagsName) use ($article) { //use: クロージャの中の処理で変数$articleを使うため
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            //firstOrCreate: 引数として渡した「カラム名と値のペア」を持つレコードがテーブルに存在するかどうかを探し、もし存在すればそのモデルを返す
            $article->tags()->attach($tag); //記事とタグの紐付け(article_tagテーブルへのレコードの保存)
        });
    }

    public function edit(Article $article) //DI:型宣言 new $articleを作成
    {
        return view('articles.edit', ['article' => $article]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all())->save();
        return redirect()->route('articles.index');
    }

    public function destroy(Article $article) //DI
    {
        $article->delete();
        return redirect()->route('articles.index');
    }

    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article]);

    }

    public function like(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        //記事モデルと、リクエストを送信したユーザーのユーザーモデルの両者を紐づけるlikesテーブルのレコードが新規登録
        //detachメソッドであれば、逆に削除
        //2重いいねの防止策(先に削除してからattach)
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
            //likesテーブルを更新した後は、上記の連想配列をクライアントにレスポンス
        ];
    }

    public function unlike(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }
}
