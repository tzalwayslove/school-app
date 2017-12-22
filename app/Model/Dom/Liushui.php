<?php
/**
 * Created by PhpStorm.
 * User: b1151
 * Date: 2017/12/21
 * Time: 22:11
 */

namespace App\Model\Dom;


use App\Exceptions\LoginErrorException;
use App\Exceptions\TableNotFoundException;
use Symfony\Component\DomCrawler\Crawler;

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

    public function getData($startTime, $endTime)
    {
        $url = '/accounthisTrjn2.action';
        $data['inputStartDate'] = $startTime;
        $data['inputEndDate'] = $endTime;

        $res = $this->postData($url, $data);

        $res = iconv('gbk', 'utf-8', $res->__toString());

        if(strpos($res, '请重新登陆')){
            throw new LoginErrorException('请重新登陆');
        }

        $dom = new Crawler($res);

        $errDom = $dom->filterXPath('//p[@class="biaotou"]');
        if($errDom->count()){
            throw new \Exception($errDom->text());
        }

        echo $res;
        die();

        sleep(500);

        $res = $this->getPage('/accounthisTrjn3.action');
        $res = iconv('gbk', 'utf-8',$res);

        echo $res;
        die();

        $dom = new Crawler();

        $table = $dom->filterXPath('//table[@class="dangrichaxun"]');

        if(!$table->count()){
            throw new TableNotFoundException('获取数据失败！');
        }
        $trs = $table->filterXPath('//tr');
        if(!$trs->count()){
            return collect([]);
        }
        $res = $trs->each(function(Crawler $tr, $index){
            if($index == 0){
                return [];
            }

            $liusui = new \App\Lib\Liushui();
            $liusui->create_at = $tr->filterXPath('//td[1]') -> count()
                                ? $tr->filterXPath('//td[1]') -> text()
                                : '';
            $liusui->xingming = $tr->filterXPath('//td[3]') -> count()
                ? $tr->filterXPath('//td[3]') -> text()
                : '';
            $liusui->price = $tr->filterXPath('//td[6]') -> count()
                ? $tr->filterXPath('//td[6]') -> text()
                : '';
            $liusui->yue = $tr->filterXPath('//td[7]') -> count()
                ? $tr->filterXPath('//td[7]') -> text()
                : '';
            return $liusui;
        });
        return collect($res)->filter(function($item){
            return !empty($item);
        });
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

        $data['threeDaysAgo'] = [
            'start_time'=>date($format, $now - 3 * self::$day),
            'end_time' =>date($format, $now),
            'name'=>'三天前'
        ];
        $data['aWeekAgo'] = [
            'start_time'=>date($format, $now - ($N - 1) * self::$day),
            'end_time' =>date($format, $now),
            'name'=>'这周'
        ];
        $data['ThisMonth'] = [
            'start_time'=>date($format, mktime(0,0,0, date('m'), 1)),
            'end_time' =>date($format, strtotime(date('Y-m-t'))),
            'name'=>'本月'
        ];

        $data['lastMonth'] = [
            'start_time'=>date($format, mktime(0,0,0, date('m')-1, 1)),
            'end_time' =>date($format, mktime(0,0,0,date('m'), 1) -1),
            'name'=>'上月'
        ];
        $data['twoMonthsAgo'] = [
            'start_time'=>date($format, mktime(0,0,0, date('m')-2, 1)),
            'end_time' =>date($format, mktime(0,0,0, date('m')-1, 1)-1),
            'name' =>date('m月', mktime(0,0,0, date('m')-2, 1))
        ];
        $data['threeMonthAgo']= [
            'start_time'=>date($format, mktime(0,0,0, date('m')-3, 1)),
            'end_time' =>date($format, mktime(0,0,0, date('m')-2, 1)-1),
            'name' =>date('m月', mktime(0,0,0, date('m')-3, 1))
        ];
        $data['foreMonthAgo'] = [
            'start_time'=>date($format, mktime(0,0,0, date('m')-4, 1)),
            'end_time' =>date($format, mktime(0, 0,0, date('m')-3, 1) -1),
            'name' =>date('m月', mktime(0,0,0, date('m')-4, 1))
        ];
        $data['all']=[
            'start_time'=>date($format, mktime(0,0,0,0,0,0)),
            'end_time' =>date($format, $now),
            'name' =>'所有'
        ];
        return $data;
    }
}