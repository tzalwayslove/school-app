<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/6
 * Time: 12:52
 */

namespace App\Model\Dom;


use App\Exceptions\NoPingjiaoException;
use App\Exceptions\PingjiaoCompleteException;
use Illuminate\Support\Debug\Dumper;
use Symfony\Component\DomCrawler\Crawler;

class Pingjiao extends Login
{
    public $queryUrl = '/xsd/xspj/xspj_find.do?Ves632DSdyV=NEW_XSD_JXPJ';
    public $queryPage = null;
    public $pingjiaoUrl = '';
    public $pingjiaopage = null;
    public $saveUrl = '/xsd/xspj/xspj_save.do';

    public function __construct($user_name, $password)
    {
        parent::__construct($user_name, $password);

        $query = [
            'xsfs' => 'all'
        ];

        $res = $this->postData(Chengji::$search_url, $query);

        if(!strpos($res,'评教未完成，不能查询成绩！')){
            throw new PingjiaoCompleteException('已经评教了！');
        }

    }

    public function getQueryUrl()
    {

        $html = $this->getPage($this->queryUrl);
        $this->queryPage = new Crawler($html->__toString());

        $f = $this->queryPage->filterXPath('//table[@class="Nsb_r_list Nsb_table"]//td[7]/a');
        $alinkCount = $f->count();

        if ($alinkCount > 0) {
            $this->pingjiaoUrl = $f->attr('href');
        }
    }

    public function pingjiao()
    {

        $this->getQueryUrl();
        $html = $this->getPage($this->pingjiaoUrl);


        $this->pingjiaopage = new Crawler($html->__toString());

        $this->pingjiaopage->filterXPath('//table[@id="dataList"]/tr')->each(function (Crawler $tr, $index) {

            $f = $tr->filterXPath('//td[8]/a');

            if ($f->count()) {
                $js = $f->attr('href');
                $link = substr($js, strpos($js, '(') + 2, strpos($js, ')') - strpos($js, '(') - 12);

                $pingjiaoHtml = $this->getPage($link);
                echo $pingjiaoHtml;

                $pingjiaoPage = new Crawler($pingjiaoHtml->__toString());

                $postRadioDataTemp = $pingjiaoPage->filterXPath('//input[@type="radio"]')->each(function (Crawler $hidden) {
                    return [
                        $hidden->attr('name') => $hidden->attr('value')
                    ];
                });

                $postHiddenDataTemp = $pingjiaoPage->filterXPath('//input[@type="hidden"]|input[@type="radio"]')->each(function (Crawler $hidden, $index) {
                    return [
                        $hidden->attr('name') => $hidden->attr('value')
                    ];
                });

                $data = [];
                foreach ($postHiddenDataTemp as $hidden) {
                    foreach ($hidden as $name => $value) {
                        if (isset($data[$name])) {
                            $data[$name . 'a__' . str_random(6) . '__a'] = $value;
                        } else {
                            $data[$name] = $value;
                        }
                    }
                }

                $i = 0;
                foreach ($postRadioDataTemp as $radio) {
                    foreach ($radio as $name => $value) {
                        $data[$name][] = $value;
                    }
                    ++$i;
                }

                $suiji = rand(0, $i / 4 - 1);

                $i = 0;
                foreach ($data as $key => $item) {
                    if (is_array($item)) {
                        if ($suiji == $i) {
                            $data[$key] = $item[1];
                        } else {
                            $data[$key] = $item[0];
                        }
                        $i++;
                    }
                }

                $data['issubmit'] = 1;
                $str = http_build_query($data);
                $str = preg_replace('/a__(.*?)__a/', '', $str);

                $this->postData($this->saveUrl, $str, [
                    'Content-Type'=>'application/x-www-form-urlencoded'
                ]);
            }
        });

    }
}