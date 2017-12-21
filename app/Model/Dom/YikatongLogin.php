<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/21
 * Time: 11:14
 */

namespace App\Model\Dom;


class YikatongLogin
{
    public $user_name;
    public $passwrod;
    public $pre = 'http://1900mx9281.51mypc.cn';

    public function __construct($user_name, $password)
    {
        $this->user_name;
        $this->passwrod;

        $res = $this->postData('/loginstudent.action', [
            'name'=>$user_name,
            'userType'=>1,
            'passwd'=>$password,
            'loginType'=>1,
            'rand'=>'88', //验证码
            'imageField.x'=>rand(1, 100),
            'imageField.y'=>rand(1, 100)
        ]);

        echo $res;
        die();
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
                'char_set' => 'gbk',
                'body' => $data,
                'headers'=>$header
            ]);
        }else{
            $res = $this->client->request('post', $this->pre . $url, [
                'cookies' => $this->jar,
                'char_set' => 'gbk',
                'form_params' => $data,
                'headers'=>$header
            ]);
        }


        return $res->getBody();
    }
}