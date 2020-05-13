<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Article extends Model
{
    //$article->user->nameとコードを書くことで、記事モデルから紐付くユーザーモデルのプロパティ(ここではname)にアクセスできるようになる
    //userメソッドの戻り値が、BelongsToクラスであることを宣言
    public function user(): BelongsTo 
    {
        return $this->belongsTo(('App\User'));
        //thisは、Articleクラスのインスタンス自身を指す
        // $this->メソッド名()とすることで、インスタンスが持つメソッドが実行
        // $this->プロパティ名とすることで、インスタンスが持つプロパティを参照
    }

}
