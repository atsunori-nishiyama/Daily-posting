<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //nameプロパティをセットしてタグモデルを保存すること(tagsテーブルにレコードを保存すること)が可能となる
    protected $fillable = [
        'name',
    ];

    public function getHashtagAttribute(): string
    {
        return '#' .$this->name;
    }
}
