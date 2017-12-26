<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/1
 * Time: 13:18
 */

namespace App\Model\Dom;


use App\Exceptions\LoginErrorException;
use App\Model\User;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\TransferStats;
use Symfony\Component\DomCrawler\Crawler;

class Login
{
    protected $account;
    protected $password;
    protected $key;
    protected $jar;
    protected $login = false;
    public $login_res;
    public $info_url = '/xsd/grxx/xsxx?Ves632DSdyV=NEW_XSD_XJCJ'; //我的卡片地址
    public $faculty;    //院系
    public $_class;     //课程
    public $infoPage;
//    protected $pre = 'http://1900mx9281.51mypc.cn'; //http://222.27.186.113
    protected $pre = 'http://222.27.186.112';
    protected $client;

    /**
     * Login constructor.
     * @param $user_name
     * @param $password
     * @throws LoginErrorException
     */
    public function __construct($user_name, $password)
    {
        $this->account = $user_name;
        $this->password = $password;

        $this->jar = new CookieJar;
        $this->client = new Client();

        $url = $this->pre . '/xsd/xk/LoginToXk';

        $res = $this->client->request('post', $url, [
            'form_params' => [
                'USERNAME' => $user_name,
                'PASSWORD' => $password
            ],
            'cookies' => $this->jar,
            'char_set' => 'gbk'
        ]);

        $this->login_res = $res->getBody();

        $errorDom = new Crawler(iconv('gbk', 'utf-8//IGNORE', $this->login_res->__toString()));
        $filter = $errorDom->filterXPath('//font[@color="red"]');

        if($filter->count() != 0){
            $error = trim($filter->text());
            if ($error) {
                throw new LoginErrorException($error);
            }
        }
    }

    public function getInfo()
    {
        $url = '/xsd/grxx/xsxx?Ves632DSdyV=NEW_XSD_XJCJ';
        $res = $this->getPage($url);
        $dom = new Crawler($res->__toString());
        $table = $dom->filterXPath('//table[@id="xjkpTable"]');
        if(!$table->count()){
            return false;
        }

        $name = $table->filterXPath('//tr[4]/td[2]');
        $info = [];
        if($name->count()){
            $info['name'] = trim($name->text(), ' ');

        }
//        48
        $idCard = $table->filterXPath('//tr[48]/td[4]');

        if($idCard->count()){
            $info['id_card'] = $idCard->text();
            $info['yikatong_password'] = substr($info['id_card'], -6);
        }

        User::where('account', $this->account)->update($info);

        return User::whereAccount($this->account)->first();
    }
    public function getPage($url)
    {
        $res = $this->client->request('get', $this->pre . $url, [
            'cookies' => $this->jar,
            'char_set' => 'gbk',
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

    /*public function getInfo()
    {
        $res = $this->getPage($this->info_url);
        $this->infoPage = new Crawler($res->__toString());

//        $this->faculty = $this->infoPage->filterXPath('//table[@id=]/tr[3]')->html();

        dd($this->faculty);
        echo $res;
        die();

        $this->_class = trim($this->infoPage->filterXPath('//tr[3]/td[4]')->text(), '班级：');

    }*/
}