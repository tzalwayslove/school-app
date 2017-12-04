<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/4
 * Time: 9:18
 */

namespace App\Model\Dom;


use Symfony\Component\DomCrawler\Crawler;

class Chengji extends Login
{
    public $search_url = '/xsd/kscj/cjcx_list';
    public $get_search_url = '/xsd/kscj/cjcx_query';
    public $query = '';
    public $crawler = null;
    private $nowChengji = false;

    /**
     * 获取最新成绩
     * @return mixed|null
     */
    public function getChengji()
    {
        $list = [];
        $get_search_page = $this->getPage($this->get_search_url);

        $this->crawler = new Crawler($get_search_page->__toString());

        $chengjiList = $this->crawler->filterXPath('//select[@id="kksj"]//option')->each(function (Crawler $node, $k) use($list) {
            if ($k == 0 || $this->nowChengji) {
                return;
            }

            $xueqi = $node->attr('value');

            $res = $this->postData($this->search_url, [
                'kksj' => $xueqi
            ]);

            $data = $this->getData((new Crawler($res->__toString()))->filterXPath('//table[@id="dataList"]'));

            if($data->isNotEmpty()){
                $this->nowChengji = true;
                return $data;
            }

            return null;

        });
        $res = collect($chengjiList)->filter(function($v){
            return !is_null($v);
        });

        if($res->isNotEmpty()){
            return $res->pop();
        }else{
            return null;
        }
    }

    public function all()
    {
        $query = [
            'xsfs'=> 'all'
        ];

        $res = $this->postData($this->search_url, $query);
        $data = $this->getData((new Crawler($res->__toString()))->filterXPath('//table[@id="dataList"]'));

        return $data;
    }

    public function getData(Crawler $tableNode)
    {


        $res = $tableNode->filterXPath('//tr')->each(function (Crawler $tr, $index) {
            if ($index == 0) {
                return ;
            }
            $chengji = new \App\Lib\Chengji();
            $chengji->kaikeshijian = $tr->filterXPath('//td[2]')->text();
            $chengji->kechengbianhao = $tr->filterXPath('//td[3]')->text();
            $chengji->kecengmingceng = $tr->filterXPath('//td[4]')->text();
            $chengji->chengji = $tr->filterXPath('//td[5]')->text();
            $chengji->xuefen = $tr->filterXPath('//td[6]')->text();
            $chengji->zongxueshi = $tr->filterXPath('//td[7]')->text();
            $chengji->kaohefangshi = $tr->filterXPath('//td[8]')->text();
            $chengji->kechengshuxing = $tr->filterXPath('//td[9]')->text();
            $chengji->kechengxingzhi = $tr->filterXPath('//td[10]')->text();
            $chengji->kaoshixingzhi = $tr->filterXPath('//td[11]')->text();
            $chengji->lurushijian = $tr->filterXPath('//td[12]')->text();

            dd($chengji);
            return $chengji;
        });

        dd($res);

        if(isset($res[0]) || !$res[0]){
            unset($res[0]);
        }

        return collect($res);
    }
}