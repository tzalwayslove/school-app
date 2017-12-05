<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/5
 * Time: 13:15
 */

namespace App\Model\Dom;


use Symfony\Component\DomCrawler\Crawler;

class Kaochang extends Login
{
    public $query_url = '/xsd/xsks/xsksap_query';
    public $query_page = null;
    public $data_url = '/xsd/xsks/xsksap_list';
    public $data_page = null;

    public function getQueryData()
    {
        $html = $this->getPage($this->query_url);
        $this->query_page = new Crawler($html->__toString());
        $options = $this->query_page->filterXPath('//select[@id="xnxqid"]/option');

        $it = $options->getIterator()->getArrayCopy();
        $options = array_reverse($it);

        $data = collect();
        
        foreach ($options as $option) {
            if ($data->isNotEmpty()) {
                break;
            }
            $value = (new Crawler($option))->attr('value');
            $list_page = $this->postData($this->data_url, [
                'xnxqid' => $value
            ]);
            $data = $this->getDataFromListData(new Crawler($list_page->__toString()));
        }
        return $data;
    }

    public function getDataFromListData(Crawler $page)
    {
        $kaochangs = $page->filterXPath('//table[@id="dataList"]/tr')->each(function (Crawler $tr, $index) {
            if ($index == 0) {
                return null;
            }
            $f = $tr->filterXPath('//td[2]');
            $changci = $f->count() > 0
                ? $f->text()
                : "";
            $f = $tr->filterXPath('//td[3]');
            $bianhao = $f->count() > 0
                ? $f->text()
                : "";
            $f = $tr->filterXPath('//td[4]');
            $name = $f->count() > 0
                ? $f->text()
                : "";
            $f = $tr->filterXPath('//td[5]');
            $shijian = $f->count() > 0
                ? $f->text()
                : "";
            $f = $tr->filterXPath('//td[6]');
            $kaochang = $f->count() > 0
                ? $f->text()
                : "";
            $f = $tr->filterXPath('//td[7]');
            $zuoweihao = $f->count() > 0
                ? $f->text()
                : "";
            $f = $tr->filterXPath('//td[8]');
            $zhunkaozhenghao = $f->count() > 0
                ? $f->text()
                : "";
            if($kaochang || $name || $shijian || $changci || $zhunkaozhenghao || $zuoweihao || $bianhao){
                $oc = new \App\Lib\Kaochang();
                $oc->kaochang = $kaochang;
                $oc->name = $name;
                $oc->shijian = $shijian;
                $oc->changci = $changci;
                $oc->zhunkaozhenghao = $zhunkaozhenghao;
                $oc->zuoweihao = $zuoweihao;
                $oc->bianhao = $bianhao;
                return $oc;
            }else{
                return null;
            }


        });
        $kaochangs = collect($kaochangs);
        return $kaochangs->filter(function($value){
            return !is_null($value);
        });
    }
}