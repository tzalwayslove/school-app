<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wechat extends Model
{
    protected $table = 'wechat';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    use SoftDeletes;

    public static function getOne($type, $key)
    {
        $wechat = self::where('type', $type)->where('key', $key)->first();

        return isset($wechat->content)
            ? $wechat->content
            : null;
    }
}
