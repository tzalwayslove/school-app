<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 11:14
 */

namespace App\Model\Dom;


use App\Exceptions\LoginErrorException;
use App\Model\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;

class YikatongLogin
{
    public $user_name;
    public $passwrod;
    public $pre = 'http://1900mx9281.51mypc.cn';
    public $jar;

    public function __construct($user_name, $password)
    {
        $this->user_name = $user_name;
        $this->passwrod = $password;

        if(session('isLogin') && session('cookie_jar')){
            $jar = session('cookie_jar');
        }else{
            $jar = new CookieJar();
        }

        $this->jar = $jar;
        $this->client = new Client();
        if(!session('isLogin')){
            $this->getPage('/homeLogin.action');// 获取sessionId
        }
    }


    public function getCode()
    {
        $res = $this->getPage('/getCheckpic.action');
        session(['cookie_jar'=>serialize($this->jar)]);
        return $res;
    }

    /**
     * 此方法依赖getCode()获取验证码
     * @param $code
     * @throws LoginErrorException
     */
    public function login($code)
    {
        $data = [
            'name'=>$this->user_name,
            'userType'=>1,
            'passwd'=>$this->passwrod,
            'loginType'=>2,
            'rand'=>$code, //验证码
            'imageField.x'=>rand(1, 100),
            'imageField.y'=>rand(1, 100)
        ];

        $res = $this->postData('/loginstudent.action', $data);

        $res = $res->__toString();

        $erroDom = new Crawler($res);
        $filter = $erroDom->filterXPath('//p[@class="biaotou"]');

        if($filter->count()){
            throw new LoginErrorException($filter->text());
        }
        session(['cookie_jar'=>$this->jar]);
        session(['isLogin'=>true]);
    }

    public function getPage($url)
    {
        $res = $this->client->request('get', $this->pre . $url, [
            'cookies' => $this->jar,
            'char_set' => 'utf-8',
            'headers' => [
                'connection'=>'keep-alive'
            ]
        ]);
        return $res->getBody();
    }

    public function postData($url, $data, $header=[])
    {
        $resData = [];
        foreach($data as $key=>$val){
            $arr = [];
            $arr['name'] =$key;
            $arr['contents'] = $val;
            $resData[] = $arr;
        }

        $res = $this->client->request('post', $this->pre . $url, [
            'cookies' => $this->jar,
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