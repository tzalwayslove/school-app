<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/4
 * Time: 9:18
 */

namespace App\Model\Dom;
use App\Exceptions\NoPingjiaoException;
use Symfony\Component\DomCrawler\Crawler;

class Chengji extends Login
{
    public static $search_url = '/xsd/kscj/cjcx_list';
    public $get_search_url = '/xsd/kscj/cjcx_query';
    public $query = '';
    public $crawler = null;
    private $nowChengji = false;
    public static $map = [
        '序号'=>'xuhao',
        '平时成绩'=>'pingshichengji',
        '平时成绩比例'=>'pingshichengjibili',
        '期末成绩'=>'qimochengji',
        '期末成绩比例'=>'qimochengjibili',
        '总成绩'=>'zongchengji'
    ];

    /**
     * 获取最新成绩
     * @return mixed|null
     */
    public function getChengji($xueqi=false)
    {
        $list = [];

        if(!$xueqi){
            //未指定学期
            $get_search_page = $this->getPage($this->get_search_url);
            $this->crawler = new Crawler($get_search_page->__toString());

            $chengjiList = $this->crawler->filterXPath('//select[@id="kksj"]//option')->each(function (Crawler $node, $k) use ($list) {

                if ($k == 0 || $this->nowChengji) {
                    return null;
                }

                $xueqi = $node->attr('value');

                $res = $this->postData(self::$search_url, [
                    'kksj' => $xueqi
                ]);

                if(strpos($res,'评教未完成，不能查询成绩！')){
                    throw new NoPingjiaoException('评教未完成，不能查询成绩！');
                }

                $data = $this->getData((new Crawler($res->__toString()))->filterXPath('//table[@id="dataList"]'));

                if ($data->isNotEmpty()) {
                    $this->nowChengji = true;
                    return $data;
                }

                return null;

            });
        }else{
            //指定学期
            $res = $this->postData(self::$search_url, [
                'kksj' => $xueqi
            ]);

            if(strpos($res,'评教未完成，不能查询成绩！')){
                throw new NoPingjiaoException('评教未完成，不能查询成绩！');
            }

            $data = $this->getData((new Crawler($res->__toString()))->filterXPath('//table[@id="dataList"]'));
            $chengjiList[] = $data;
        }


        $res = collect($chengjiList)->filter(function ($v) {
            return !is_null($v);
        });

        if ($res->isNotEmpty()) {
            return $res->pop();
        } else {
            return null;
        }
    }

    public function getOption()
    {
        $get_search_page = $this->getPage($this->get_search_url);
        $this->crawler = new Crawler($get_search_page->__toString());

        $res = $this->crawler->filterXPath('//select[@id="kksj"]//option')->each(function(Crawler $option, $index){
            if($index == 0){
                return null;
            }else{
                return $option->text();
            }
        });
        $list = [];
        foreach($res as $option){
            if(!is_null($option)){
                $list[] = $option;
            }
        }
        return $list;
    }
    /**
     * 获取全部成绩
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $query = [
            'xsfs' => 'all'
        ];

        $res = $this->postData(self::$search_url, $query);

        if(strpos($res,'评教未完成，不能查询成绩！')){
            throw new NoPingjiaoException('评教未完成，不能查询成绩！');
        }

        $html = (new Crawler($res->__toString()))->filterXPath('//table[@id="dataList"]');
        $data = $this->getData($html);

        return $data;
    }

    public function getData(Crawler $tableNode)
    {
        $res = $tableNode->filterXPath('//tr')->each(function (Crawler $tr, $index) {

            if ($index == 0) {
                return;
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

            $js = $tr->filterXPath('//td[5]/a')->attr('href');
            $link = substr($js, strpos($js, '(') + 2, strpos($js, ')') - strpos($js, '(') - 11);
            $chengji->chengji_info = $this->getChengjiInfo($link);

            return $chengji;
        });

        unset($res[0]);

        return collect($res);
    }

    public function getChengjiInfo($url)
    {
        $html = $this->getPage($url);
        $page = new Crawler($html->__toString());
        $theader = $page->filterXPath('//table[@id="dataList"]//th');
        $data[] = '';

        $fields = $theader->each(function(Crawler $th, $index){
            return $th->text();
        });

        foreach($fields as $key=>$field){
            $index = $key+1;

            $data[self::$map[$field]] = $page->filterXPath('//table[@id="dataList"]//td['.$index.']')->count() > 0
                ? trim($page->filterXPath('//table[@id="dataList"]//td['.$index.']')->text(), ' &nbsp')
                : '';
        }
        unset($data[0]);
        return $data;
    }
}