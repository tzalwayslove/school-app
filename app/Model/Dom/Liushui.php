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
}