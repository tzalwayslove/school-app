<?php

namespace App\Model;

use GuzzleHttp\Client;
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

    public static function newArticel($title, $content, $cate = 0, $niming = false)
    {

        $articel = new Articel();
        $articel->title = $title;
        $articel->content = $content;
        $articel->cate = $cate;
        $articel->niming = $niming ? 1 :0;
        $articel->save();
    }

    public static function minganci($str)
    {
        $client = new Client();
        $res = $client->request('GET', 'http://www.hoapi.com/index.php/Home/Api/check?str='.$str);
        dd($res->getBody);
    }

}
