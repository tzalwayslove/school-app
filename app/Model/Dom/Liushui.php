<?php
/**
 * Created by PhpStorm.
 * User: b1151
 * Date: 2017/12/21
 * Time: 22:11
 */

namespace App\Model\Dom;


use App\Exceptions\LoginErrorException;
use App\Exceptions\noAccountException;
use App\Exceptions\TableNotFoundException;
use Symfony\Component\DomCrawler\Crawler;

class Liushui extends YikatongLogin
{
    public static $day = 86400;
    public static $week = 604800;
    public $account = '';
    public $price = 0; //余额

    public function __construct($user_name, $password)
    {
        parent::__construct($user_name, $password);
        $res = $this->getPage('/accounthisTrjn.action');

        $res = iconv('gbk', 'utf-8', $res);
        $dom = new Crawler($res);
        $error = $dom->filterXPath('//p[@class="biaotou"]');

        if($error->count()){
            throw new LoginErrorException($error->text());
        }

        $option = $dom->filterXPath('//select[@id="account"]/option[1]');

        if(!$option->count()){
            throw new noAccountException('没有一卡通账号!');
        }


        $str = $this->getPage('/accountcardUser.action');
        $yue = iconv('gbk', 'utf-8', $str);
        echo $yue;
        die();

        $this->account = $option->attr('value');
        $this->postData('/accounthisTrjn1.action', [
            'account'=>$option->attr('value'),
            'inputObject'=>'all',
            'Submit'=>'(unable to decode value)'
        ]);


    }

    public function getData($startTime, $endTime, $page=1)
    {
        $url = '/accounthisTrjn2.action';
        $data['inputStartDate'] = $startTime;
        $data['inputEndDate'] = $endTime;
        $data['pageNum'] = $page;


        $res = $this->postData($startTime != $endTime ? $url : '/accounttodayTrjn.action', $data, []);

        $res = iconv('gbk', 'utf-8', $res->__toString());

        if(strpos($res, '请重新登陆')){
            throw new LoginErrorException('请重新登陆');
        }

        $dom = new Crawler($res);

        $errDom = $dom->filterXPath('//p[@class="biaotou"]');
        if($errDom->count()){
            throw new \Exception($errDom->text());
        }

        $pageUrl = '/accountconsubBrows.action';
        $url = '/accounthisTrjn3.action';

        $postUrl =$page == 1 ? $url : $pageUrl;
        if($startTime == $endTime){
            $postUrl = '/accounttodatTrjnObject.action';
            $data  = [];
            $data['account'] = $this->account;
            $data['inputObject'] = 'all';
            $data['Submit'] = '(unable to decode value)';
        }

        $res = $this->postData($postUrl, $data);
        $res = iconv('gbk', 'utf-8',$res);

        $dom = new Crawler($res);
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
            $liusui->created_at = $tr->filterXPath('//td[1]') -> count()
                                ? $tr->filterXPath('//td[1]') -> text()
                                : '';
            $liusui->xingming = $tr->filterXPath('//td[3]') -> count()
                ? $tr->filterXPath('//td[3]') -> text()
                : '';
            $liusui->shanghu = $tr->filterXPath('//td[5]') -> count()
                ? $tr->filterXPath('//td[5]') -> text()
                : '';
            $liusui->price = $tr->filterXPath('//td[6]') -> count()
                ? $tr->filterXPath('//td[6]') -> text()
                : '';
            $liusui->yue = $tr->filterXPath('//td[7]') -> count()
                ? $tr->filterXPath('//td[7]') -> text()
                : '';
            $liusui->type = $tr->filterXPath('//td[4]') -> count()
                ? $tr->filterXPath('//td[4]') -> text()
                : '';

            return $liusui;
        });
        $nextPage = $dom->filterXPath('//a[@href="javascript:button14_Onclick();"]');
        $prePage = $dom->filterXPath('//A[@href="javascript:button13_Onclick();"]');//上一页

        $resData['data'] = collect($res)->filter(function($item, $key)use ($res){
            return !empty($item) && $key!= count($res)-1;
        })->all();
        $resData['nextPage'] = !!$nextPage->count();
        $resData['prePage'] = !!$prePage->count();

        return $resData;

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

        $data['now']=[
            'start_time'=>date($format, $now),
            'end_time' =>date($format, $now),
            'name' =>'这天'
        ];
        return $data;
    }

    public function getPage($url, $jar=null)
    {

        $res = $this->client->request('get', $this->pre . $url, [
            'cookies' => $jar? $jar : $this->jar,
            'char_set' => 'utf-8',
            'headers' => [
                'connection'=>'keep-alive'
            ]
        ]);
        return $res->getBody();
    }

    public function postData($url, $data, $header=null, $jar=null)
    {
        $resData = [];
        foreach($data as $key=>$val){
            $arr = [];
            $arr['name'] =$key;
            $arr['contents'] = $val;
            $resData[] = $arr;
        }

        $res = $this->client->request('post', $this->pre . $url, [
            'cookies' => $jar? $jar :$this->jar,
            'char_set' => 'gbk',
            'multipart' => $resData,
            'headers'=>$header,
            'allow_redirects'=>true,
            'max'=>5, //重定向次数
            'strict'=>'false'//是否严格重定向，不明觉厉 false
        ]);

        return $res->getBody();
    }
}