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
     * @param bool $f true 获取当前周， false获取所有
     * @return array
     */
    public function getSearchQuery($f = true)
    {
        $html = $this->getPage($this->searchQueryUrl);
        $searchPage = new Crawler($html->__toString());
        $xnxq01id = $searchPage->filterXPath('//select[@id="xnxq01id"]/option[1]')->text();

        $data = [
//            'zc'=> $this->weekNum,
            'xnxq01id' => $xnxq01id
        ];

        if (!$f) {
            unset($data['xnxq01id']);
        }
        return $data;
    }

    public function getTable()
    {
        $html = $this->postData($this->searchQueryUrl, $this->getSearchQuery());

        $page = new Crawler($html->__toString());
        return $this->getData($page->filterXPath('//table[@id="kbtable"]'));
    }

    public function getData(Crawler $table)
    {
        $kecheng = [];
        for ($i = 2; $i < 8; ++$i) {
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
