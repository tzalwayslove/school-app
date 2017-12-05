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

    public function getQueryData()
    {
        $html = $this->getPage($this->query_url);
        $this->query_page = new Crawler($html->__toString());
        $options = $this->query_page->filterXPath('//select[@id="xnxqid"]/option');
        $it = $options->getIterator();
        $options = array_reverse($it);

        dd($options);
        foreach($options as $option){
            dd($option->text());
        }

    }
}