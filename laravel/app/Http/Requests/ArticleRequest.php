<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

     //リクエストの対象となるリソース(ここでは記事)をユーザーが更新して良いかどうかを判定
     //判定結果に応じてtrueかfalseを返すようにすることで、記事を更新する権限の無いユーザーからのリクエストは受け付けない
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'title' => 'required|max:50',
            'body' => 'required|max:500',
            //JSON形式かどうかのバリデーションを行う
            //PHPにおいて半角スペースが無いこと,/が無いことをチェック
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'body' => '本文',
            'tags' => 'タグ'
        ];
    }

    public function passedValidation()
    {
        //SON形式の文字列であるタグ情報をPHPのjson_decode関数を使って連想配列に変換
        //collect関数を使ってコレクションに変換
        $this->tags = collect(json_decode($this->tags))
            //コレクションの要素が、第一引数に指定したインデックスから第二引数に指定した数だけになる
            //タグ入力フォームに"タグを5個まで入力できます"と表示する対応
            ->slice(0, 5)
            //mapメソッド: コレクションの各要素に対して順に処理を行い、新しいコレクションを作成
            //$requestTagには、mapメソッドを使うコレクションの要素が入る
            ->map(function ($requestTag){
                return $requestTag->text;
            });
    }
}
