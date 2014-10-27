<?php

namespace crawler;


class Mp3WebCrawler extends WebCrawler {
    private $mp3Pattern;

    protected function crawl($content, $host) {
        $results = (new Grep($content,$this->mp3Pattern))->getResult();
        foreach ($results as $link) {
            $mp3 = trim($link);
            if (!$this->isAbsoluteUrl($link)) {
                $mp3 = $host . trim($link);
            }
            if(!$this->repository->exists($mp3)){
                $this->repository->save($mp3);
            }
        }
    }

    protected function init(){
        $this->mp3Pattern = new RegExPattern('/((http:\/)?\/(www)?[-a-zA-Z0-9@:%_\+.~#?\/=]+\.mp3)[^A-Za-z0-9]/',1);
    }
}