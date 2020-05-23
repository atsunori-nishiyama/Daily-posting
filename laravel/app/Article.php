<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = [
        'title',
        'body',
    ];

    //$article->user->nameとコードを書くことで、記事モデルから紐付くユーザーモデルのプロパティ(ここではname)にアクセスできるようになる
    //userメソッドの戻り値が、BelongsToクラスであることを宣言
    public function user(): BelongsTo 
    {
        return $this->belongsTo(('App\User'));
        //thisは、Articleクラスのインスタンス自身を指す
        // $this->メソッド名()とすることで、インスタンスが持つメソッドが実行
        // $this->プロパティ名とすることで、インスタンスが持つプロパティを参照
    }

    public function likes(): BelongsToMany
    {
        //belongsToManyメソッドの第一引数には関係するモデルのモデル名を
        //第二引数には中間テーブルのテーブル名を渡し
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
        //withTimestamps:likesテーブルには、created_at、updated_atカラムが存在
    }

    // [?]を付けると、その引数がnullであることも許容
    public function isLikedBy(?User $user): bool
    {
        return $user
            //三項演算子を用いて$userがnullかどうかによって処理を振り分け
            //この記事をいいねしたユーザーの中に、引数として渡された$userがいるかどうかを調べる
            //countメソッドは、コレクションの要素数を数えて、数値を返し
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
            //$userがnullであれば、falseを返し
            //型キャスト:(bool)と記述することで変数を論理値、つまりtrueかfalseに変換
    }

    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }

}
