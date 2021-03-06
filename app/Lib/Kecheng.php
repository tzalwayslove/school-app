<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/5
 * Time: 9:30
 */

namespace App\Lib;


use Symfony\Component\DomCrawler\Crawler;

class Kecheng
{
    public $name;
    public $teacher;
    public $week;
    public $jiaoshi;

    public function __construct($name = null, $teacher = null, $week = null, $jiaoshi)
    {
        $this->name = $name;
        $this->teacher = $teacher;
        $this->week = $week;
        $this->jiaoshi = $jiaoshi;
    }

    /**
     * @param $html
     * @return \Illuminate\Support\Collection
     */
    public static function getInfoFromHtml($html)
    {
        $kechengs = explode ('---------------------<br>', $html);
        $data = [];

        foreach($kechengs as $kecheng){
            $pos = strpos($kecheng,'<br>');
            $name = substr($kecheng, 0, $pos);
            $temp = new Crawler('<div>'.$kecheng.'</div>');
            $teacher = $temp->filterXPath('//font[@title="老师"]')->count() > 0
                ? $temp->filterXPath('//font[@title="老师"]')->text()
                : '';
            $week = $temp->filterXPath('//font[@title="周次(节次)"]')->count() > 0
                ? $temp->filterXPath('//font[@title="周次(节次)"]')->text()
                : '';
            $jiaoshi = $temp->filterXPath('//font[@title="教室"]')->count() > 0
                ? $temp->filterXPath('//font[@title="教室"]')->text()
                : '';
            if($name || $teacher || $week || $jiaoshi){
                $data[] = new self($name, $teacher, $week, $jiaoshi);
            }
        }

        return collect($data);
    }
}