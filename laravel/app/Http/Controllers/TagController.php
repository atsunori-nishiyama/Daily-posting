<?php

namespace App\Http\Controllers;

use App\Tag;

use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(string $name)
    {
        //whereメソッドを使って、$nameと一致するタグ名を持つタグモデルをコレクションで取得
        $tag = Tag::where('name', $name)->first();

        return view('tags.show', ['tag' => $tag]);
    }
}
