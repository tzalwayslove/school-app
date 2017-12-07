<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/6
 * Time: 12:52
 */

namespace App\Model\Dom;


use Illuminate\Support\Debug\Dumper;
use Symfony\Component\DomCrawler\Crawler;

class Pingjiao extends Login
{
    public $queryUrl = '/xsd/xspj/xspj_find.do?Ves632DSdyV=NEW_XSD_JXPJ';
    public $queryPage = null;
    public $pingjiaoUrl = '';
    public $pingjiaopage = null;
    public $saveUrl = '/xsd/xspj/xspj_save.do';

    public function getQueryUrl()
    {
        $html =$this->getPage($this->queryUrl);
        $this->queryPage = new Crawler($html->__toString());

        $f = $this->queryPage->filterXPath('//table[@class="Nsb_r_list Nsb_table"]//td[7]/a');
        $alinkCount = $f->count();

        if($alinkCount > 0){
            $this->pingjiaoUrl = $f->attr('href');
        }
    }

    public function pingjiao()
    {
        $this->getQueryUrl();
        $html = $this->getPage($this->pingjiaoUrl);

        $this->pingjiaopage = new Crawler($html->__toString());

        $res = $this->pingjiaopage->filterXPath('//table[@id="dataList"]/tr')->each(function(Crawler $tr, $index){
            if($index != 1){
                return null;
            }

            $f = $tr->filterXPath('//td[8]/a');
            if($f->count()){
                $js = $f->attr('href');
                $link = substr($js, strpos($js, '(') +2, strpos($js, ')') - strpos($js, '(') -12);

                $pingjiaoHtml = $this->getPage($link);

                $pingjiaoPage = new Crawler($pingjiaoHtml->__toString());


                $postRadioDataTemp = $pingjiaoPage->filterXPath('//input[@type="radio"]')->each(function(Crawler $hidden){
                    return [
                        $hidden->attr('name')=>$hidden->attr('value')
                    ];
                });

                $postHiddenDataTemp = $pingjiaoPage->filterXPath('//input[@type="hidden"]|input[@type="radio"]')->each(function(Crawler $hidden, $index){
                    return [
                        $hidden->attr('name')=>$hidden->attr('value')
                    ];
                });
                $data = [];
                foreach($postHiddenDataTemp as $hidden){
                    foreach($hidden as $name=>$value){
                        if(isset($data[$name])){
                            $data[$name.'a__'.str_random(6).'__a'] = $value;
                        }else{
                            $data[$name] = $value;
                        }

                    }
                }
                $i=0;
                foreach($postRadioDataTemp as $radio){
                   foreach($radio as $name=>$value){
                       $data[$name][] = $value;
                   }
                    ++$i;
                }

                foreach($data as $key => $item){
                    if(is_array($item)){
                        $data[$key] = $item[0];
                    }
                }

                $str = http_build_query($data);

                $str = preg_replace ('/a__(.*?)__a/', '', $str);

                $res = $this->postData($this->saveUrl, $str, [
                    'Content-Type'=>'application/x-www-form-urlencoded'
                ]);

                echo $res;
                die();

                if($index == 3){
                    echo $res;
                    die();
                }
            }
        });

    }
}