<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 11:14
 */

namespace App\Model\Dom;


use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;

class YikatongLogin
{
    public $user_name;
    public $passwrod;
    public $pre = 'http://1900mx9281.51mypc.cn';

    public function __construct($user_name, $password)
    {
        $this->user_name;
        $this->passwrod;
        $this->jar = new CookieJar();
        $this->client = new Client();


        /*$res = $this->postData('/loginstudent.action', [
            'name'=>$user_name,
            'userType'=>1,
            'passwd'=>$password,
            'loginType'=>1,
            'rand'=>'88', //验证码
            'imageField.x'=>rand(1, 100),
            'imageField.y'=>rand(1, 100)
        ]);

        echo $res;
        die();*/
    }

    public function getCode()
    {
        $res = $this->getPage('/getCheckpic.action');
        return $res;
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
        if(is_string($data)){
            $res = $this->client->request('post', $this->pre . $url, [
                'cookies' => $this->jar,
                'char_set' => 'utf-8',
                'body' => $data,
                'headers'=>$header
            ]);

        }else{
            $res = $this->client->request('post', $this->pre . $url, [
                'cookies' => $this->jar,
                'char_set' => 'utf-8',
                'form_params' => $data,
                'headers'=>$header
            ]);
        }


        return $res->getBody();
    }
}