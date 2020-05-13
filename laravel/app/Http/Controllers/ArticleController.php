<?php

namespace App\Http\Controllers;

use App\Article;
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
}
