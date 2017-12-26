<?php

namespace App\Model\Dom;


use App\Lib\Kecheng;
use App\Model\Setting;
use Carbon\Carbon;
use Symfony\Component\DomCrawler\Crawler;

class Kechengbiao extends Login
{
    public $weekNum;
    private $searchQueryUrl = '/xsd/xskb/xskb_list.do';

    public function __construct($user_name, $password)
    {
        parent::__construct($user_name, $password);

        $start_school = new Carbon(Setting::getOne('start_school'));
        $now = new Carbon(date('Y-m-d'));

        $diffDays = $now->diffInDays($start_school);
        $this->weekNum = intval($diffDays / 7);

    }

    /**
     * @param bool $p false 获取当前周， true获取所有
     * @return array
     */
    public function getSearchQuery($p)
    {
        $html = $this->getPage($this->searchQueryUrl);
        $searchPage = new Crawler($html->__toString());
        if($p == 'next'){
            $xnxq01id = $searchPage->filterXPath('//select[@id="xnxq01id"]/option[1]')->text();
        }else{
            $xnxq01id = $searchPage->filterXPath('//select[@id="xnxq01id"]/option[2]')->text();
        }

        $data = [
            'zc'=> $this->weekNum,
            'xnxq01id' => $xnxq01id
        ];

        if ($p == 'all') {
            unset($data['zc']);
        }
        return $data;
    }

    public function getTable($p)
    {
        $html = $this->postData($this->searchQueryUrl, $this->getSearchQuery($p));

        $page = new Crawler($html->__toString());
        $table = $page->filterXPath('//table[@id="kbtable"]');

        return [
            'table'=> $this->getData($table),
            'desc'=> $this->getDesc($table)
        ];
    }

    public function getDesc(Crawler $table)
    {
        return $table->filterXPath('//td[@colspan="7"]')->count() > 0
            ? $table->filterXPath('//td[@colspan="7"]')->text()
            : '';
    }
    public function getData(Crawler $table)
    {
        $kecheng = [];
        for ($i = 2; $i < 7; ++$i) {
            $kecheng[] = $table->filterXPath('//tr[' . $i . ']/td')->each(function (Crawler $html, $key) {
                if ($html->filterXPath('//div[@class="kbcontent"]')->count() > 0) {
                    return Kecheng::getInfoFromHtml($html->filterXPath('//div[@class="kbcontent"]')->html());
                } else {
                    return collect([]);
                }
            });
        }

        return collect($kecheng);
    }


}
