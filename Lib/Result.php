<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/29
 * Time: 16:23
 */

namespace App\Lib;



class Result
{
    public $code;
    public $message;

    public function __construct($res, $message='', $code='')
    {
        if($res && $code == ''){
            $this->code = 1;
        }else{
            $this->code = $code == '' ? 0 : $code;
        }
        $this->message = $message;
    }
}
