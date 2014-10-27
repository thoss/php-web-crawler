<?php

namespace crawler;


interface CrawlRepository {
    /**
     * @param $url
     */
    public function save($url);

    /**
     * @param $url
     * @return bool
     */
    public function exists($url);
} 