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
        $user = session('user');
        $articel = new Articel();
        $articel->title = $title;
        $articel->content = $content;
        $articel->cate = $cate;
        $articel->niming = $niming ? 1 : 0;
        $articel->user = $user->id;
        $articel->save();
    }

    public static function minganci($str)
    {
        $client = new Client();
        $res = $client->request('GET', 'http://www.hoapi.com/index.php/Home/Api/check?str=' . $str);
        dd($res->getBody);
    }

    public static function getTimeAgo($the_time)
    {
        $now_time = date("Y-m-d H:i:s", time());
        $now_time = strtotime($now_time);
        $show_time = strtotime($the_time);
        $dur = $now_time - $show_time;
        if ($dur < 0) {
            return $the_time;
        } else {
            if($dur  < 3){
                return '刚刚';
            }else{
                if ($dur < 60) {
                    return $dur . '秒前';
                } else {
                    if ($dur < 3600) {
                        return floor($dur / 60) . '分钟前';
                    } else {
                        if ($dur < 86400) {
                            return floor($dur / 3600) . '小时前';
                        } else {
                            if ($dur < 8640000) {//100天内
                                return floor($dur / 86400) . '天前';
                            } else {
                                return '很久以前';
                            }
                        }
                    }
                }
            }

        }
    }
}
