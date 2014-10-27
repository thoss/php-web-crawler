<?php

namespace crawler;


class InMemoryCrawlRepository implements CrawlRepository {
    private $urlStack = [];

    /**
     * @param $url
     */
    public function save($url) {
        $this->urlStack[] = $url;
    }

    /**
     * @param $url
     * @return bool
     */
    public function exists($url) {
        return in_array($url,$this->urlStack);
    }

    /**
     * @return mixed
     */
    public function getUrlStack() {
        return $this->urlStack;
    }

    public function clear(){
        $this->urlStack = array();
    }

}