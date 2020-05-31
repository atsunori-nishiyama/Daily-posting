<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(string $name)
    {
        //firstメソッドを使ってコレクションから最初のユーザーモデル1件を取り出し、変数$userに代入
        $user = User::where('name', $name)->first();

        return view('users.show', [
            'user' => $user,
        ]);
    }

    public function follow(Request $request, string $name)
    {
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id)
        {
            return abort('404', 'Cannot follow yourself.');
        }

        //必ず削除(detach)してから新規登録(attach)
        $request->user()->followings()->detach($user);
        $request->user()->followings()->attach($user);

        return ['name' => $name];
    }

    public function unfollow(Request $request, string $name)
    {
        //whereメソッドで、条件に一致するユーザーモデルをコレクションとしてコレクションの最初の1件のユーザーモデルを取得
        $user = User::where('name', $name)->first();

        if ($user->id === $request->user()->id)
        {
            //abort関数を使ってエラーのHTTPステータスコードをレスポンス
            return abort('404', 'Cannot follow yourself.');
        }

        $request->user()->followings()->detach($user);

        return ['name' => $name];
    }
}
