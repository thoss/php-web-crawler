<?php

namespace crawler;


class ImageWebCrawler extends WebCrawler {
    private $imagePattern;

    protected function crawl($content, $host) {
        $results = (new Grep($content,$this->imagePattern))->getResult();
        foreach ($results as $link) {
            $image = $link;
            if (!$this->isAbsoluteUrl($link)) {
                $image = ($this->startWith($link,'/')) ? $host . $link : $host .'/' . $link;
            }
            if(!$this->repository->exists($image)){
                $this->repository->save($image);
            }
        }
    }

    protected function init(){
        $this->imagePattern = new RegExPattern('/((http:\/\/)?(www)?[-a-zA-Z0-9@:%_\+.~#?\/= ]+\.(jpeg|png|jpg|gif))[^A-Za-z0-9]/',1);
    }
}