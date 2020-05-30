<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Article')->withTimestamps();
    }
}
