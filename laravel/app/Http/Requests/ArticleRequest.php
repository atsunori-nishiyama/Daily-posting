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
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'body' => '本文',
        ];
    }
}
