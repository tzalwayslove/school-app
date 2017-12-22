<?php
/**
 * Created by PhpStorm.
 * User: b1151
 * Date: 2017/12/21
 * Time: 22:11
 */

namespace App\Model\Dom;


use App\Exceptions\LoginErrorException;

class Liushui extends YikatongLogin
{
    public static $day = 86400;
    public static $week = 604800;
    /*
     * 获取查询条件返回数组
        此函数依赖父类的登录方法必须先登录，否则抛出登录Exception
    */
    public function getQueryList()
    {
        $url = '/accounthisTrjn1.action';
        if(!session('isLogin')){
            throw new LoginErrorException('请重新登录!');
        }
        $res = $this->getPage($url);

        dd(iconv('gbk', 'utf-8', $res));
    }

    public static function getSelectDate()
    {
        //三天
        //这周
        //一月内
        //这月
        //上月
        //10月份
        //9月份
        $format = 'Ymd';
        $now = time();
        $N = date('N');//今天星期几

        dd($N);
        $data['threeDaysAgo'] = [
            date($format, $now - 3 * self::$day),
            date($format, $now)
        ];
        $data['aWeekAgo'] = [
            date($format, $now - strtotime($N) * self::$day),
            date($format, $now),
        ];
        $data['ThisMonth'] = [
            date($format, mktime(0,0,0, date('m'), 1)),
            date($format, strtotime(date('Y-m-t')))
        ];

        $data['lastMonth'] = [
            date($format, mktime(0,0,0, date('m')-1, 1)),
            date($format, mktime(0,0,0,date('m'), 1) -1)
        ];
        $data['twoMonthsAgo'] = [
            date($format, mktime(0,0,0, date('m')-2, 1)),
            date($format, mktime(0,0,0, date('m')-1, 1)-1)
        ];
        $data['threeMonthAgo']= [
            date($format, mktime(0,0,0, date('m')-3, 1)),
            date($format, mktime(0,0,0, date('m')-2, 1)-1)
        ];
        return $data;
    }
}