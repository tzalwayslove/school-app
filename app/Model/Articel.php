<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Articel extends Model
{
    protected $table = 'articel';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    use SoftDeletes;

    public function user_account()
    {
        return $this->belongsTo('App\Model\User', 'user', 'id');
    }

    public function cate_name()
    {
        return $this->belongsTo('App\Model\Cate', 'cate', 'id');
    }

    public function getComment()
    {
        return $this->hasMany('App\Model\Comment', 'articel', 'id');
    }

    public static function newArticel($title, $content, $cate = 0)
    {
        $articel = new Articel();
        $articel->title = $title;
        $articel->content = $content;
        $articel->cate = $cate;
        $articel->save();
    }

}
