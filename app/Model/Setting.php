<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    protected $table = 'setting';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    use SoftDeletes;

    public static function setOne($key, $value)
    {
        $data['key'] = $key;
        $data['value'] = $value;

        self::updateOrCreate(['key'=>$key], ['key'=>$key, 'value'=>$value]);

    }

    public static function getOne($key)
    {
        $setting = self::where('key', $key)->first();

        return isset($setting->value)
            ? $setting->value
            : null;
    }
}
